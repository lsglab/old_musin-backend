<?php

namespace App\Http\Validators;

use App\Tables\UserTable;

class UserValidator extends BaseValidator{

    public function __construct(){
        $this->table = new UserTable();
    }
}

