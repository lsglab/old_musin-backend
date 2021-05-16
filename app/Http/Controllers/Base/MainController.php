<?php

namespace App\Http\Controllers\Base;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\generated\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use App\Models\generated\EntryPermission;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public Request $request;
    public string $model;
    public array $createValidation = [];
    public array $editValidation = [];

    public function __construct(){
        $this->request = request();

        if(count($this->editValidation) === 0){
            foreach($this->createValidation as $key => $value){
                $type = gettype($value);

                if($type === 'string'){
                    $this->editValidation[$key] = preg_replace("/((?<=\|)|(?<=^))(required)((?=\|)|(?=$))/",'nullable',$value);
                } else if($type === 'array'){
                    foreach($value as &$aValue){
                        if ( $aValue === 'required' ) $aValue='nullable';
                    }
                    $this->editValidation[$key] = $value;
                }
            }
        }

        unset($this->request['userPermission']);
    }

    public function handle($action = null){
        $this->request = request();
        if($action === null){
            $action = $this->request->userPermission;
        }
        unset($this->request['userPermission']);

        switch($action){
            case 'read':
                return $this->handleRead();
                break;
            case 'read-self':
                return $this->handleReadSelf();
                break;
            case 'edit':
                return $this->handleEdit();
                break;
            case 'edit-self':
                return $this->handleEditSelf();
                break;
            case 'delete':
                return $this->handleDelete();
                break;
            case 'delete-self':
                return $this->handleDeleteSelf();
                break;
            case 'create':
                return $this->handleCreate();
                break;

            default:
                return $this->respond(['message' => 'action_does_not_exist'],400);
                break;
        }
    }

    function handleRead(){
        $data = $this->read();
        return $this->isResponse($data) ? $data : $this->afterRead($data);
    }

    function handleReadSelf(){
        $data = $this->read_self();
        return $this->isResponse($data) ? $data : $this->afterRead($data);
    }

    function handleEdit(){
        $edit = $this->read();
        $data = $this->edit($edit);
        return $this->isResponse($data) ? $data : $this->afterEdit($data);
    }

    function handleEditSelf(){
        $edit = $this->read_self();
        $data = $this->edit($edit);
        return $this->isResponse($data) ? $data : $this->afterEdit($data);
    }

    function handleDelete(){
        $delete = $this->read();
        $data = $this->delete($delete);
        return $this->isResponse($data) ? $data : $this->afterDelete($data);
    }

    function handleDeleteSelf(){
        $delete = $this->read_self();
        $data =  $this->delete($delete);
        return $this->isResponse($data) ? $data : $this->afterDelete($data);
    }

    function handleCreate(){
        $body = $this->getRequestBody();

        if(gettype($body) !== 'array'){
            return $this->respond(['message' => 'Invalid data. Expected object or array'],400);
        }

        $data = array();

        if(!array_key_exists('0',$body)){
            $body = array($body);
        }

        foreach($body as $ele){
            $created = $this->create($ele);
            if($this->isResponse($created)){
                return $created;
            }
            array_push($data,$created);
        }

        return $this->afterCreate($data);
    }

    function isResponse($data){
        if(gettype($data) !== 'object'){
            return false;
        }
        if(get_class($data) === 'Illuminate\Http\JsonResponse'){
            return true;
        }
        return false;
    }

    function respond($array,$status = 200){
        return response()->json($array,$status);
    }

    function getInput($input){
        $prop = $this->request->input($input);

        if(gettype($prop) === 'NULL'){
            return false;
        } else {
            return $prop;
        }
    }

    function getQuery(){
        $query = $this->request->query();

        if(count($query) > 0){
            return $query;
        } else {
            return false;
        }
    }

    function getPermission($role_id,$table,$action){
        $permission = Permission::where('role_id',$role_id)
            ->where('table',$table)
            ->where('action',$action)
            ->first();

        if($permission === NULL){
            return false;
        }else {
            return $permission;
        }
    }

    function getEqualObjects($array1,$array2){
        $return = array();

        $array1 = $this->toArray($array1);
        $array2 = $this->toArray($array2);

        foreach($array1 as $ele1){
            foreach($array2 as $ele2){
                if($ele1->id === $ele2->id){
                    array_push($return,$ele1);
                }
            }
        }

        return $return;
    }

    function toArray($var){
        $type = gettype($var);

        if(!is_iterable($var)){
            return array($var);
        } else {
            return $var;
        }
    }

    function getColumns(){
        $columns = Schema::getColumnListing($this->table);
        return array_diff($columns,$this->hidden);
    }

    function filterData($object){
        $columns = Schema::getColumnListing($this->table);
        $keys = array_keys($object);
        $diff = array_diff($keys,$columns);
        foreach($diff as $key){
            unset($object[$key]);
        }
        return $object;
    }

    function queryBuilder($builder = null,$query = null){
        $role_id = auth()->user()->role_id;

        if($builder === null){
            $builder = $this->model::where('id','!=',-1);
        }

        /*$hasEntryPermissions = count($this->model::whereHas('entry_permissions',function($query) use ($role_id){
            $query->where('role_id',$role_id);
        })->get()) > 0;

        $baseAction = $this->getAction();

        $builder->when($hasEntryPermissions,function($query) use($baseAction,$role_id){
            return $query->whereHas('entry_permissions',function($query) use ($baseAction,$role_id){
                $query->where('action',$baseAction);
                $query->where('role_id',$role_id);
            });
        });*/

        if($query === null){
            $query = $this->getQuery();
        }
        $columns = $this->getColumns();

        if(!$query){
            return $builder;
        }

        foreach($query as $key => $value){
            if($key==='search'){
                $builder = $builder->where(function($query) use ($columns,$value){
                    foreach($columns as $column){
                        $query = $query->orWhere($column,'like','%'.$value.'%');
                    }
                });

            } else if($key === 'orderBy'){
                $split = explode(',',$value);
                $method = 'asc';
                if(count($split) > 1){
                    $method = $split[1] == 'desc' || $split[1] == 'asc' ? $split[1] : $method;
                }
                $column = $split[0];

                if(in_array($column,$columns)){
                    $builder->orderBy($column,$method);
                }
            }
            else if(in_array($key,$columns)){
                if($value === "null"){
                    $builder = $builder->whereNull($key);
                } else {
                    $builder = $builder->where($key,$value);
                }
            } else {
                //just add a query that always fails -> empty array is returned
                $builder = $builder->where('id',-1);
            }
        }

        return $builder;
    }

    function getRequestBody(){
        return json_decode($this->request->getContent(),true);
    }

    function afterRead($data){
        // $data = $this->remove($data);
        return $this->processDataAndRespond($data);
    }

    function afterEdit($updated){
        $updated = array($updated);
        return $this->processDataAndRespond($updated);
    }

    function afterCreate($created){
        return $this->processDataAndRespond($created);
    }

    function afterDelete($deleted){
        return $this->processDataAndRespond($deleted);
    }

    function processDataAndRespond($data){
        return $this->respond([$this->table => $data]);
    }

    function setData($data,$self,$relation){
        $return = $this->getEqualObjects($data->$relation,$self);

        unset($data->$relation);
        $data->$relation = $return;
        return $data;
    }

    function getRelation($data,$relation,$controller,$checkPermission = true){
        $roleId = auth()->user()->role_id;

        $foreignClass = new $controller;
        $subject = Subject::where('table',$foreignClass->table)->first();

        if($this->getPermission($roleId,$subject->id,'read') !== false || $checkPermission === false){
            $self = $foreignClass->read(false);
            $data = $this->setData($data,$self,$relation);

        } else if($this->getPermission($roleId,$subject->id,'read-self') !== false){

            $self = $foreignClass->read_self(false);
            $data = $this->setData($data,$self,$relation);

        } else {
            $data->$relation = array();
        }

        return $data;
    }

    function read($query = null){
        if($query === null){
            $query = $this->getQuery();
        }

        $builder = $this->queryBuilder(null,$query);
        $data = $builder->get();

        return $data;
    }

    function read_self($query = null){
        if($query === null){
            $query = $this->getQuery();
        }

        $user = auth()->user();

        $builder = $this->model::where('creator_id',$user->id);

        $builder = $this->queryBuilder($builder,$query);

        $data = $builder->get();

        return $data;
    }

    function edit($edit){
        $count = count($edit);

        if($count > 1){
            return $this->respond(['message' => 'You can only edit one entry at once'],400);
        } else  if($count == 0){
            return $this->respond(['message' => 'No entry found or no permission to edit'],404);
        }

        $edit = $edit[0];

        $validate = $this->validate_edit($edit);

        if($validate !== true){
            return $validate;
        }

        $editData = $this->getRequestBody();
        $editData = $this->filterData($editData);

        foreach($editData as $key => $value){
            $edit = $this->edit_one($edit,$key,$value);
        }

        $edit->save();

        return $edit;
    }

    function edit_one($entry,$key,$value){
        switch($key){
            case "password":
                $entry->$key = Hash::make($value);
                break;
            default:
                $entry->$key = $value;
                break;
        }

        return $entry;
    }

    function delete($query){
        $body = $this->getRequestBody();
        $delete = array();

        function getQueryEle($query,$id){
            foreach($query as $ele){
                if($ele->id === $id){
                    return $ele;
                }
            }
            return false;
        }

        if($body != null && array_key_exists('ids',$body)){
            foreach($body['ids'] as $id){
                if(gettype($id) !== 'integer'){
                    return $this->respond(['message' => 'Id must be of type integer'],400);
                }

                $filter = getQueryEle($query,$id);

                if($filter !== false){
                    array_push($delete,$filter);
                }
            }
        } else {
            $delete = $query;
        }

        $count = count($delete);

        if($count == 0){
            return $this->respond(['message' => 'No entry found or no permission to delete'],404);
        }

        foreach($delete as $entry){
            $this->delete_one($entry);
        }

        return $delete;
    }

    function delete_one($entry){
        $subject = Subject::where('table',$this->table)->first();

        if($subject !== null){
            foreach($subject->children as $child){
                $relation = $child->attributes->firstWhere('relation',$subject->id);

                if($relation !== null){
                    DB::delete("delete from $child->table where $relation->name = $entry->id");
                }
            }
        }

        $entry->delete();
    }

    function create($create = null){
        if($create == null){
            $create = $this->request->all();
        }

        $validate = $this->validate_create($create);

        if($validate !== true){
            return $validate;
        }

        $created = $this->create_one($create);

        return $created;
    }

    function create_one($create){
        $array = [];
        $columns = Schema::getColumnListing($this->table);

        foreach($columns as $key){
            if(array_key_exists($key,$create)){
                switch($key){
                    case 'password':
                        $array[$key] = Hash::make($create[$key]);
                    default:
                        $array[$key] = $create[$key];
                }
            }

            if($key === 'creator_id'){
                $array[$key] = auth()->user()->id;
            }
        }

        return $this->model::create($array);
    }

    function validateRequest($validation,$object = null){
        if($object == null){
            $object = $this->request->all();
        }

        $validator = Validator::make($object,$validation);

        if($validator->fails()){
            return $this->respond($validator->errors(), 400);
        }

        return true;
    }

    function create_edit_validation($create){

    }

    function create_create_validation($create){

    }

    function validate_edit($edit,$object = null){
        if($object == null){
            $object = $this->request->all();
        }

        $this->create_edit_validation($edit);

        return $this->validateRequest($this->editValidation,$object);
    }

    function validate_create($object = null){
        if($object == null){
            $object = $this->request->all();
        }

        $this->create_create_validation($object);

        return $this->validateRequest($this->createValidation,$object);
    }

    function getAction(){
        switch($this->request->method()){
            case 'POST':
                return 'create';
                break;
            case 'GET':
                return 'read';
                break;
            case 'PUT':
                return 'edit';
                break;
            case 'DELETE':
                return 'delete';
                break;
        }
    }
}
