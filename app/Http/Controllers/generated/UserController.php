<?php

namespace App\Http\Controllers\generated;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\MainController;
//own model; 
use App\Models\generated\Role; 
use App\Http\Controllers\UserController as ManualUserController; 
use App\Http\Controllers\RoleController as RoleController; 
use Illuminate\Support\Facades\Hash; 
use App\Models\User; 



class UserController extends MainController
{

    function read(){
        $builder = User::where('id','!=',-2);
        $query = $this->getQuery();

        if(!$query){
            $data = User::all();
        } else {
            $builder = $this->queryBuilder($builder,User::all()[0]);

            $data = $builder->get();
        }

        return $data;
    }

    function read_self(){
        $query = $this->getQuery();
        $user = auth()->user();

        $builder = User::where('creator_id',$user->id);

        if($query != false){
            $builder = $this->queryBuilder($builder,User::all()[0]);
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
        	
        	    $foreignClass = new ManualUserController();
        	    $self = $foreignClass->read_self();
        	    $return = $this->getEqualObjects($data->created_by,$self);
        	
        	    unset($data->created_by);
        	    $data->created_by = $return;
        	} else {
              $data->created_by = array();
        	}

        	if($this->getPermission($role->id,3,'read') !== false){
        	    $data->roles;
        	} else if($this->getPermission($role->id,3,'read-self') !== false){
        	
        	    $foreignClass = new RoleController();
        	    $self = $foreignClass->read_self();
        	    $return = $this->getEqualObjects($data->roles,$self);
        	
        	    unset($data->roles);
        	    $data->roles = $return;
        	} else {
              $data->roles = array();
        	}

        }

        return $this->respond(['users' => $array]);
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

        
        $created = User::create([
            
			'creator_id' => auth()->user()->id,
			'name' => $create['name'],
			'email' => $create['email'],
			'password' => Hash::make($create['password']),
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
			'email' => 'required|email|unique:users', 
			'password' => 'required|string|min:8|confirmed', 
			'role_id' => 'required|exists:roles,id', 

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
			'email' => 'nullable|email|unique:users', 
			'password' => 'nullable|string|min:8|confirmed', 
			'role_id' => 'nullable|exists:roles,id', 

        ]);

        if($validator->fails()){
            return $this->respond($validator->errors(), 400);
        }

        return true;
    }
}