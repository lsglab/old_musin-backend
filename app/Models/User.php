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
        $this->hidden = ModelFunctions::getHidden($this);
        $this->fillable = ModelFunctions::getFillable($this);
        $this->attributes = ModelFunctions::getAttributes($this);
        $this->casts = ModelFunctions::getCasts($this);
        $this->table = ModelFunctions::getTable($this);
        parent::__construct($attributes);
    }

    public function entry_permissions(){
        return $this->getRelation(__FUNCTION__);
    }

    public function created_by(){
        return $this->getRelation(__FUNCTION__);
    }

    public function role(){
        return $this->getRelation(__FUNCTION__);
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
