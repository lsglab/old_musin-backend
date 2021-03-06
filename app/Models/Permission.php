<?php

namespace App\Models;

use App\Models\Base\BasePermission;
use App\Tables\PermissionTable;

class Permission extends BasePermission{

    public function __construct(array $attributes = []){
        $this->t_table = new PermissionTable();
        parent::__construct($attributes);
    }
}
