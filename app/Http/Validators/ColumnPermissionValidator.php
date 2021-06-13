<?php

namespace App\Http\Validators;

use App\Tables\ColumnPermissionTable;

class ColumnPermissionValidator extends BaseValidator{

    public function __construct(){
        $this->table = new ColumnPermissionTable();
    }
}
