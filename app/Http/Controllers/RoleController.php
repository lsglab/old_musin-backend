<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\generated\Role;
use App\Http\Controllers\generated\RoleController as GeneratedRoleController;


class RoleController extends GeneratedRoleController
{
    function read_self(){
        $query = $this->getQuery();
        $user = auth()->user();

        $builder = Role::where('id',$user->roles->id);

        if($query != false){
            $builder = $this->queryBuilder($builder,Role::all()[0]);
        }

        $data = $builder->get();

        return $data;
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
