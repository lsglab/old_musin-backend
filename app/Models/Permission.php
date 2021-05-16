<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use App\Tables\PermissionTable;

class Permission extends BaseModel{

    public function __construct(array $attributes = []){
        $this->t_table = new PermissionTable();
        parent::__construct($attributes);
    }
}
