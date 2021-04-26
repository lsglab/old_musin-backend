<?php

namespace App\Http\Controllers\generated;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\MainController;
use App\Models\User; 
use App\Models\generated\Permission; 
use App\Http\Controllers\UserController as UserController; 
use App\Http\Controllers\PermissionController as PermissionController; 
use App\Models\generated\Role; 



class RoleController extends MainController
{

    function read(){
        $builder = Role::where('id','!=',-2);
        $query = $this->getQuery();

        if(!$query){
            $data = Role::all();
        } else {
            $builder = $this->queryBuilder($builder,Role::all()[0]);

            $data = $builder->get();
        }

        return $data;
    }

    function read_self(){
        $query = $this->getQuery();
        $user = auth()->user();

        $builder = Role::where('creator_id',$user->id);

        if($query != false){
            $builder = $this->queryBuilder($builder,Role::all()[0]);
        }

        $data = $builder->get();

        return $data;
    }

    function processDataAndRespond($array){
        $role = auth()->user()->roles;

        foreach($array as &$data){
            
        	if($this->getPermission($role->id,1,'read') !== false){
        	    $data->created_by;
        	} else if($this->getPermission($role->id,1,'read-self') !== false){
        	
        	    $foreignClass = new UserController();
        	    $self = $foreignClass->read_self();
        	    $return = $this->getEqualObjects($data->created_by,$self);
        	
        	    unset($data->created_by);
        	    $data->created_by = $return;
        	} else {
              $data->created_by = array();
        	}

        	if($this->getPermission($role->id,2,'read') !== false){
        	    $data->permissions;
        	} else if($this->getPermission($role->id,2,'read-self') !== false){
        	
        	    $foreignClass = new PermissionController();
        	    $self = $foreignClass->read_self();
        	    $return = $this->getEqualObjects($data->permissions,$self);
        	
        	    unset($data->permissions);
        	    $data->permissions = $return;
        	} else {
              $data->permissions = array();
        	}

        	if($this->getPermission($role->id,1,'read') !== false){
        	    $data->users;
        	} else if($this->getPermission($role->id,1,'read-self') !== false){
        	
        	    $foreignClass = new UserController();
        	    $self = $foreignClass->read_self();
        	    $return = $this->getEqualObjects($data->users,$self);
        	
        	    unset($data->users);
        	    $data->users = $return;
        	} else {
              $data->users = array();
        	}

        }

        return $this->respond(['roles' => $array]);
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

        
        $created = Role::create([
            
			'creator_id' => auth()->user()->id,
			'name' => $create['name'],
			'description' => $create['description'],
			'admin' => $create['admin'],
			'permissions' => $create['permissions'],
			'role_id' => $create['role_id'],

        ]);

        return $created;
    }

    function validate_create($object = null){
        if($object == null){
            $object = $this->request->all();
        }

        $validator = Validator::make($object,[
            
			'name' => 'required|string', 
			'description' => 'nullable|string', 
			'admin' => 'required|boolean', 

        ]);

        if($validator->fails()){
            return $this->respond($validator->errors(), 400);
        }

        return true;
    }

    function validate_edit($object = null){
        if($object == null){
            $object = $this->request->all();
        }

        $validator = Validator::make($this->request->all(),[
            
			'name' => 'nullable|string', 
			'description' => 'nullable|string', 
			'admin' => 'nullable|boolean', 

        ]);

        if($validator->fails()){
            return $this->respond($validator->errors(), 400);
        }

        return true;
    }
}