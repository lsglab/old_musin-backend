<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use App\Models\Base\ModelInterface;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Tables\UserTable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject,ModelInterface{
    public $t_table;

    public function __construct(array $attributes = []){
        $this->t_table = new UserTable();
        $this->hidden = $this->t_table->hidden;
        $this->fillable = $this->t_table->fillable;
        $this->casts = $this->t_table->casts;
        $this->attributes = $this->t_table->attributes;
        $this->table = $this->t_table->table;
        parent::__construct($attributes);
    }

    public function getRelation($name){
        $relation = array_values(array_filter($this->t_table->relations,function($value) use ($name){
            return $value->getFunctionName() === $name;
        }));

        if(count($relation) > 0){
            $relation = $relation[0];
            $data = $relation->get($this)->values();

            if(count($data) === 1){
                return $data[0];
            }

            return $data;
        }

        return [];
    }

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJwtCustomClaims(){
        return [];
    }
}
