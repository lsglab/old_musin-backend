<?php

use Database\Base\BaseMigration;
use App\Tables\ComponentTable;

class CreateComponentsTable extends BaseMigration{

    public function __construct(){
        $this->table = new ComponentTable();
    }
}
