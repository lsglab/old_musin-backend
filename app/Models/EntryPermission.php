<?php

namespace App\Models;

use App\Models\Base\MainModel;
use App\Tables\EntryPermissionTable;

class EntryPermission extends MainModel{

    public function __construct(array $attributes = []){
        $this->t_table = new EntryPermissionTable();
        parent::__construct($attributes);
    }

    public function role(){
        return $this->getRelation(__FUNCTION__);
    }

    public function entry(){
        return $this->getRelation(__FUNCTION__);
    }
}
