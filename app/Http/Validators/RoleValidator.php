<?php

namespace App\Http\Validators;

use App\Tables\RoleTable;

class RoleValidator extends BaseValidator{

    public function __construct(){
        $this->table = new RoleTable();
        parent::__construct();
    }
}
