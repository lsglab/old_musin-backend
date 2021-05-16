<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use App\Tables\User as UserTable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends BaseModel implements JWTSubject{

    public function __construct(){
        $this->t_table = new UserTable();
        parent::__construct();
    }

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJwtCustomClaims(){
        return [];
    }

    public function getAuthIdentifierName() : string{
        return $this->getKeyName();
    }

    public function getAuthIdentifier() : string{
        return $this->{$this->getAuthIdentifierName()};
    }

    public function getAuthPassword(){
        return $this->password;
    }

    public function getRememberToken(){
        if (! empty($this->getRememberTokenName())) {
            return (string) $this->{$this->getRememberTokenName()};
        }
    }

    public function setRememberToken($value){
        if (! empty($this->getRememberTokenName())) {
            $this->{$this->getRememberTokenName()} = $value;
        }
    }

    public function getRememberTokenName()
    {
        return $this->t_table->rememberTokenName;
    }
}
