<?php

namespace App\Http\Validators;

use App\Tables\EntryPermissionTable;

class EntryPermissionValidator extends BaseValidator{

    public function __construct(){
        $this->table = new EntryPermissionTable();
    }
}
