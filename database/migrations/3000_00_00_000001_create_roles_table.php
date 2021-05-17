<?php

use Database\Base\BaseMigration;
use App\Tables\RoleTable;

class CreateRolesTable extends BaseMigration{

    public function __construct(){
        $this->table = new RoleTable();
    }
}