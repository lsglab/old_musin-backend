<?php

namespace App\Http\Validators;

use App\Tables\FileTable;

class FileValidator extends BaseValidator{

    public function __construct(){
        $this->table = new FileTable();
        parent::__construct();
    }
}
