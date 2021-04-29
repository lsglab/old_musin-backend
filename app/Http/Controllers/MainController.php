<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\generated\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

class MainController extends Controller
{
    public Request $request;
    public array $actions = ['read','read-self','edit','edit-self','delete','delete-self','create'];
    public string $model;
    public string $table;
    public array $createValidation = [];
    public array $editValidation = [];
    public array $hidden = [];

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
    }

    public function handle(){
        $permission = $this->request->userPermission;
        unset($this->request['userPermission']);

        switch($permission){
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

    function getPermission($role_id,$subject_id,$action){
        $permission = Permission::where('role_id',$role_id)
            ->where('subject_id',$subject_id)
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

    function queryBuilder($builder = null){
        if($builder == null){
            $builder = $this->model::where('id','!=',-1);
        }

        $query = $this->getQuery();
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
                $builder = $builder->where($key,$value);
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
        return $this->processDataAndRespond($data);
    }

    function afterEdit($updated){
        return $this->processDataAndRespond(array($updated));
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

    function getRelation($data,$relation,$controller){
        $roleId = auth()->user()->role_id;

        if($this->getPermission($roleId,1,'read') !== false){
            $data->$relation;
        } else if($this->getPermission($roleId,1,'read-self') !== false){

            $foreignClass = new $controller;
            $self = $foreignClass->read_self();
            $return = $this->getEqualObjects($data->$relation,$self);

            unset($data->$relation);
            $data->$relation = $return;
        } else {
            $data->$relation = array();
        }

        return $data;
    }

    function read(){
        $query = $this->getQuery();

        if(!$query){
            $data = $this->model::all();
        } else {
            $builder = $this->queryBuilder();

            $data = $builder->get();
        }

        return $data;
    }

    function read_self(){
        $query = $this->getQuery();
        $user = auth()->user();

        $builder = $this->model::where('creator_id',$user->id);

        if($query != false){
            $builder = $this->queryBuilder($builder);
        }

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

        $validate = $this->validate_edit();

        if($validate !== true){
            return $validate;
        }

        $editData = $this->getRequestBody();

        foreach($editData as $key => $value){
            $edit->$key = $value;
        }

        $edit->save();

        return $edit;
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
            $entry->delete();
        }

        return $delete;
    }

    function create($create = null){
        if($create == null){
            $create = $this->request->all();
        }

        $validate = $this->validate_create($create);

        if($validate !== true){
            return $validate;
        }

        $body = $this->getRequestBody();


        $created = $this->createOne($create);

        return $created;
    }

    function createOne($create){
        $array = [];
        $columns = Schema::getColumnListing($this->table);

        foreach($columns as $key => $value){
            if(array_key_exists($key,$create)){
                switch($key){
                    case 'creator_id':
                        $array[$key] = auth()->user()->id;
                    case 'password':
                        $array[$key] = Hash::make($create[$key]);
                    default:
                        $array[$key] = $create[$key];
                }
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

    function validate_edit($object = null){
        if($object == null){
            $object = $this->request->all();
        }

        return $this->validateRequest($this->editValidation,$object);
    }

    function validate_create($object = null){
        if($object == null){
            $object = $this->request->all();
        }

        return $this->validateRequest($this->createValidation,$object);
    }
}
