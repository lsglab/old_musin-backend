<?php

namespace App\Models\Base;

class BasePermission extends MainModel{

    public function role(){
        return $this->getRelation(__FUNCTION__);
    }
}
