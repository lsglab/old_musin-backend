<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\generated\Users;

class User extends Users implements JWTSubject
{
    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJwtCustomClaims(){
        return [];
    }
}
