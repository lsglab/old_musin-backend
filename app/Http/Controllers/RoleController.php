<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\generated\Role;
use App\Http\Controllers\generated\RoleController as GeneratedRoleController;


class RoleController extends GeneratedRoleController
{
    public function __construct(){
        parent::__construct();
    }

    function read_self($query = null){
        $user = auth()->user();

        $builder = Role::where('id',$user->role->id);

        $builder = $this->queryBuilder($builder,$query);

        $data = $builder->get();
        return $data;
    }
}
