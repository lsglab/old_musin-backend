<?php

namespace App\Http\Controllers\generated;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\MainController;
use App\Models\User; 
use App\Models\generated\Role; 
use App\Models\Subject; 
use App\Http\Controllers\UserController as UserController; 
use App\Http\Controllers\RoleController as RoleController; 
use App\Http\Controllers\SubjectController as SubjectController; 
use App\Models\generated\Permission; 



class PermissionController extends MainController
{

    function read(){
        $builder = Permission::where('id','!=',-2);
        $query = $this->getQuery();

        if(!$query){
            $data = Permission::all();
        } else {
            $builder = $this->queryBuilder($builder,Permission::all()[0]);

            $data = $builder->get();
        }

        return $data;
    }

    function read_self(){
        $query = $this->getQuery();
        $user = auth()->user();

        $builder = Permission::where('creator_id',$user->id);

        if($query != false){
            $builder = $this->queryBuilder($builder,Permission::all()[0]);
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

        	if($this->getPermission($role->id,4,'read') !== false){
        	    $data->subjects;
        	} else if($this->getPermission($role->id,4,'read-self') !== false){
        	
        	    $foreignClass = new SubjectController();
        	    $self = $foreignClass->read_self();
        	    $return = $this->getEqualObjects($data->subjects,$self);
        	
        	    unset($data->subjects);
        	    $data->subjects = $return;
        	} else {
              $data->subjects = array();
        	}

        }

        return $this->respond(['permissions' => $array]);
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

        
        $duplicate = Permission::where('action',$this->request->get('action')) 
			->where('role_id',$this->request->get('role_id')) 
			->where('subject_id',$this->request->get('subject_id')) 
			->first();

        if($duplicate != null){
            return $this->respond(['message' => 'entry already exists'],400);
        }
        
        $created = Permission::create([
            
			'creator_id' => auth()->user()->id,
			'action' => $create['action'],
			'role_id' => $create['role_id'],
			'subject_id' => $create['subject_id'],

        ]);

        return $created;
    }

    function validate_create($object = null){
        if($object == null){
            $object = $this->request->all();
        }

        $validator = Validator::make($object,[
            
			'action' => 'required|in:read,read-self,edit,edit-self,delete,delete-self,create', 
			'role_id' => 'required|exists:roles,id', 
			'subject_id' => 'required|exists:subjects,id', 

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
            
			'action' => 'nullable|in:read,read-self,edit,edit-self,delete,delete-self,create', 
			'role_id' => 'nullable|exists:roles,id', 
			'subject_id' => 'nullable|exists:subjects,id', 

        ]);

        if($validator->fails()){
            return $this->respond($validator->errors(), 400);
        }

        return true;
    }
}