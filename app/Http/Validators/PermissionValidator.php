<?php

namespace App\Http\Validators;

use App\Tables\PermissionTable;

class PermissionValidator extends BaseValidator{

    public function __construct(){
        $this->table = new PermissionTable();
        parent::__construct();
    }
}
