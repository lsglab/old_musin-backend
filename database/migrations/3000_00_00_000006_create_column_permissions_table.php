<?php

use Database\Base\BaseMigration;
use App\Tables\ColumnPermissionTable;

class CreateColumnPermissionsTable extends BaseMigration{

    public function __construct(){
        $this->table = new ColumnPermissionTable();
    }
}
