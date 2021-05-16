<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use App\Tables\RoleTable;

class Role extends BaseModel{

    public function __construct(array $attributes = []){
        $this->t_table = new RoleTable();
        parent::__construct($attributes);
    }
}
