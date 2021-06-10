<?php

namespace App\Models;

use App\Models\Base\MainModel;
use App\Tables\RoleTable;

class Role extends MainModel{

    public function __construct(array $attributes = []){
        $this->t_table = new RoleTable();
        parent::__construct($attributes);
    }

    public function users(){
        return $this->getRelation(__FUNCTION__);
    }

    public function permissions(){
        return $this->getRelation(__FUNCTION__);
    }

    public function entry_permissions_by_role(){
        return $this->getRelation(__FUNCTION__);
    }
}
