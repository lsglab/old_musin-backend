<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use App\Http\Controllers\MainController;


class UserController extends MainController;
{
    public function __construct(){
        parent::__construct();
    }

    function read_self($query = null){
        $user = auth()->user();

        $builder = User::where('id',$user->id);

        $builder = $this->queryBuilder($builder,$query);

        $data = $builder->get();

        return $data;
    }
}
