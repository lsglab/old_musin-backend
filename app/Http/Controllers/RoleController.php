<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Role;
use App\Models\Subject;
use App\Models\Permission;
use App\Http\Controllers\MainController;


class RoleController extends MainController
{
    function read(){
        $id = $this->getInput('id');

        $roles;

        if($id){
            $roles = Role::where('id',$id)->get();
        } else {
            $roles = Role::all();
        }

        $roles = $this->getPermissions($roles);

        return $this->respond(['roles' => $roles]);
    }

    function read_self(){
        $id;

        if(auth()->user() !== NULL){
            $id = auth()->user()->role_id;
        } else {
            $id = Role::where('name','Public')->first()->id;
        }

        $role = Role::where('id',$id)->get();

        $role = $this->getPermissions($role);

        return $this->respond(['roles' => $role]);
    }

    function getPermissions($roles){
        $permission = $this->getInput('permissions');
        if($permission !== false){

            $subjects = Subject::all();

            foreach($roles as &$role){
                $permissions = $role->permissions;
                $rolePermissions = array();

                foreach($subjects as &$subject){
                    $subPermissions = array();

                    foreach($this->actions as $action){
                        $hasPermission = false;

                        if(count($permissions->filter(function ($value,$key) use ($action,$subject){
                            return $value->action === $action && $value->subject_id === $subject -> id;
                        })->all()) > 0){
                            $hasPermission = true;
                        }

                        $subPermissions[$action] = $hasPermission;
                    }

                    $subject->permissons = $subPermissions;
                    array_push($rolePermissions,$subject);
                }

                unset($role->permissions);
                $role->subjects = $rolePermissions;
            }
        }

        return $roles;
    }
}
