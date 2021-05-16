<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use App\Tables\Permission as PermissionTable;

class Permission extends BaseModel{

    public function __constructor(){
        $this->t_table = new PermissionTable();
        parent::__construct();
    }
}
