<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\generated\User as GeneratedUser;

class User extends GeneratedUser implements JWTSubject
{
    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJwtCustomClaims(){
        return [];
    }
}
