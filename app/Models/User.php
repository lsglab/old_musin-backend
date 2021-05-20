<?php

namespace App\Models;

use App\Models\Base\ModelFunctions;
use App\Models\Base\ModelInterface;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Tables\UserTable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject,ModelInterface{
    public $t_table;

    public function __construct(array $attributes = []){
        $this->t_table = new UserTable();

        ModelFunctions::construct($this);
        parent::__construct($attributes);
    }

    public function getRelation($name){
        return ModelFunctions::getRelation($this,$name);
    }

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJwtCustomClaims(){
        return [];
    }
}
