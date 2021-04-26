<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\generated\Permission;

class MainController extends Controller
{
    public Request $request;
    public $actions = ['read','read-self','edit','edit-self','delete','delete-self','create'];

    public function handle(Request $request){
        $this->request = $request;
        $permission = $this->request->userPermission;
        unset($request['userPermission']);

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

        $print = implode("\n",$data);
        error_log("ele:$print");

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

    function queryBuilder($builder,$example = null){
        $query = $this->getQuery();

        foreach($query as $key => $value){
            if($key==='search'){
                if($example == null) continue;

                $builder = $builder->where(function($query) use ($example,$value){
                    foreach($example->toArray() as $modelKey => $modelValue){
                        $query = $query->orWhere($modelKey,'like','%'.$value.'%');
                    }
                });

            } else{
                $builder = $builder->where($key,$value);
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
        return $this->respond(['data' => $data]);
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

    function validate_edit(){
        return true;
    }

    function validate_create(){
        return true;
    }
}
