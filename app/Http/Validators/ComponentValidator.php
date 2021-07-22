<?php

namespace App\Http\Validators;

use App\Tables\ComponentTable;

class ComponentValidator extends BaseValidator{

    public function __construct(){
        $this->table = new ComponentTable();
        parent::__construct();
    }
}
