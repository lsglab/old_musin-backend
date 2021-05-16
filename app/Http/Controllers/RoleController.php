<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\MainController;
use App\Tables\RoleTable;
use App\Http\Validators\RoleValidator;
use Illuminate\Database\Eloquent\Builder;

class RoleController extends MainController{

    public function __construct(){
        $this->table = new RoleTable();
        $this->validator = new RoleValidator();
        parent::__construct();
    }

    /*function read_self($query = null){
        $user = auth()->user();

        $builder = Role::where('id',$user->role->id);

        $builder = $this->queryBuilder($builder,$query);

        $data = $builder->get();
        return $data;
    }*/
}
