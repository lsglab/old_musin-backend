<?php

use Database\Base\BaseMigration;
use App\Tables\PermissionTable;

class CreatePermissionsTable extends BaseMigration{

    public function __construct(){
        $this->table = new PermissionTable();
    }
}