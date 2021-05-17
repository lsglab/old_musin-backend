<?php

use Database\Base\BaseMigration;
use App\Tables\UserTable;

class CreateUsersTable extends BaseMigration{

    public function __construct(){
        $this->table = new UserTable();
    }
}