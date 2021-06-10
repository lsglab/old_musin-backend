<?php

namespace App\Models;

use App\Models\Base\MainModel;
use App\Tables\PermissionTable;

class Permission extends MainModel{

    public function __construct(array $attributes = []){
        $this->t_table = new PermissionTable();
        parent::__construct($attributes);
    }

    public function role(){
        return $this->getRelation(__FUNCTION__);
    }
}
