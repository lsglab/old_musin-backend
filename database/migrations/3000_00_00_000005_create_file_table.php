<?php

use Database\Base\BaseMigration;
use App\Tables\FileTable;

class CreateFileTable extends BaseMigration{

    public function __construct(){
        $this->table = new FileTable();
    }
}
