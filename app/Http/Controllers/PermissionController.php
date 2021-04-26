<?php

namespace App\Http\Controllers;

use App\Http\Controllers\generated\PermissionController as GeneratedPermissionController;
use App\Models\generated\Permission;

class PermissionController extends GeneratedPermissionController{

    function read_self(){
        $role = auth()->user()->roles;

        return Permission::where('role_id',$role->id)->get();
    }
}
