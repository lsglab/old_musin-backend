<?php

namespace App\Models;

use App\Models\Base\BasePermission;
use App\Tables\ColumnPermissionTable;

class ColumnPermission extends BasePermission{

    public function __construct(array $attributes = []){
        $this->t_table = new ColumnPermissionTable();
        parent::__construct($attributes);
    }

}
