<?php

namespace App\Http\Controllers;

use App\Http\Controllers\generated\PermissionController as GeneratedPermissionController;
use App\Models\generated\Permission;
use App\Models\Subject;

class PermissionController extends GeneratedPermissionController{

    function read_self(){
        $role = auth()->user()->roles;

        return Permission::where('role_id',$role->id)->get();
    }

    function createOne($create){
        $permission = Permission::create([
			'creator_id' => auth()->user()->id,
			'action' => $create['action'],
			'role_id' => $create['role_id'],
			'subject_id' => $create['subject_id'],
        ]);

        $subject = $permission->subjects;

        foreach($subject->children as $child){
            $this->create([
                'creator_id' => auth()->user()->id,
                'action' => $permission->action,
                'role_id' => $permission->role_id,
                'subject_id' => $child->id
            ]);
        }

        return $permission;
    }
}
