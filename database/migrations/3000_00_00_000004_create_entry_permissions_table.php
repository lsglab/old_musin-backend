<?php

use Database\Base\BaseMigration;
use App\Tables\EntryPermissionTable;

class CreateEntryPermissionsTable extends BaseMigration{

    public function __construct(){
        $this->table = new EntryPermissionTable();
    }
}
