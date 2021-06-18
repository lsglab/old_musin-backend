<?php

use Database\Base\BaseMigration;
use App\Tables\SiteTable;

class CreateSiteTable extends BaseMigration{

    public function __construct(){
        $this->table = new SiteTable();
    }
}
