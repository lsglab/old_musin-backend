<?php

namespace App\Http\Validators;

use App\Tables\SiteTable;

class SiteValidator extends BaseValidator{

    public function __construct(){
        $this->table = new SiteTable();
    }
}
