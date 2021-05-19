<?php

namespace App\Http\Controllers\Base;

use Illuminate\Support\Facades\DB;
use App\Http\Request\Request;
use App\Http\Request\QueryBuilder;
use App\Helper;
use App\Models\Permission;

class MainController extends BaseController
{

    public function __construct(){
        parent::__construct();
    }

    public function handle($action = null){
        $this->request = new Request();
        if($action === null){
            //if no action was given, get the action from the request.
            //User permission is set by the getPermission middleware
            $action = $this->request->getInput(['userPermission']);
        }
        unset($this->request->request['userPermission']);

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

    protected function handleReadSelf(){
        $data = $this->readSelf();
        return Helper::isResponse($data) ? $data : $this->afterRead($data);
    }

    protected function handleEditSelf(){
        $edit = $this->readSelf();
        $data = $this->edit($edit);
        return Helper::isResponse($data) ? $data : $this->afterEdit($data);
    }

    protected function handleDeleteSelf(){
        $delete = $this->readSelf();
        $data =  $this->delete($delete);
        return Helper::isResponse($data) ? $data : $this->afterDelete($data);
    }

    public function readSelf($query = null){
        $user = auth()->user();

        $builder = $this->table->model::where('creator_id',$user->id);

        return $this->builder->get($builder,$query);
    }

    function getPermission($role_id,$table,$action){
        //get a permission
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

    function processDataAndRespond($array){
        /*if you add the _norelations attribute to your request no relations will be returned,
        this decreases the time needed significantly when larger samples are returned
        (e.g 50 entries without _norelations take about 4.7 seconds, with _norelations 700ms)
        */
        if($this->request->getInput('_norelations') === false){
            foreach($array as $data){
                //resolve all of the tables relations
                foreach($data->t_table->relations as $relation){
                    $table = $relation->getForeignTable($data);
                    $data = $this->getRelation($data,$relation->getFunctionName(),$table->controller);
                }
            }
        }

        return $this->respond([$this->table->table => $array]);
    }

    function setData($data,$self,$relation){
        //get the data of the model
        $rel = $data->getRelation($relation);
        //filter the two arrays. Only the elements where the ids match are returned
        $return = Helper::getEqualObjectsByKey($rel,$self,'id');
        //set the relation data;
        $data->$relation = $return;
        //return
        return $data;
    }

    function getRelation($data,$relation,$controller){
        $roleId = auth()->user()->role_id;
        //create the new controller
        $foreignClass = new $controller;
        //check for either read or read-self permission, if the user has none of them,
        //return an empty array
        if($this->getPermission($roleId,$foreignClass->table->table,'read') !== false){
            $self = $foreignClass->read(false);
            //compare the data form the controller with the data of the model
            $data = $this->setData($data,$self,$relation);

        } else if($this->getPermission($roleId,$foreignClass->table->table,'read-self') !== false){
            $self = $foreignClass->readSelf(false);
            //compare the data form the controller with the data of the model
            $data = $this->setData($data,$self,$relation);

        } else {
            $data->$relation = array();
        }

        return $data;
    }

}
