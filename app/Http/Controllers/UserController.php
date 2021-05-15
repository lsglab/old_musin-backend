<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use App\Http\Controllers\generated\UserController as GeneratedUserController;


class UserController extends GeneratedUserController
{
    public function __construct(){
        parent::__construct();
    }

    function read_self($query = null){
        if($query === null){
            $query = $this->getQuery();
        }

        $user = auth()->user();

        $builder = User::where('id',$user->id);

        if($query != false){
            $builder = $this->queryBuilder($builder,'users');
        }

        $data = $builder->get();

        return $data;
    }
}
