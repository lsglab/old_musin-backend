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
        foreach($array as $data){
            foreach($data->t_table->relations as $relation){
                $table = new $relation->foreignTable;
                $data = $this->getRelation($data,$relation->getFunctionName(),$table->controller);
            }
        }

        return $this->respond([$this->table->table => $array]);
    }

    function setData($data,$self,$relation){
        $rel = $data->getRelation($relation);
        $return = Helper::getEqualObjectsByKey($rel,$self,'id');

        $data->$relation = $return;
        return $data;
    }

    function getRelation($data,$relation,$controller){
        $roleId = auth()->user()->role_id;

        $foreignClass = new $controller;

        if($this->getPermission($roleId,$foreignClass->table->table,'read') !== false){
            $self = $foreignClass->read(false);
            $data = $this->setData($data,$self,$relation);

        } else if($this->getPermission($roleId,$foreignClass->table->table,'read-self') !== false){

            $self = $foreignClass->readSelf(false);
            $data = $this->setData($data,$self,$relation);

        } else {
            $data->$relation = array();
        }

        return $data;
    }

}
