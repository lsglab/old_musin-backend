<?php

namespace App\Tables;

use App\Tables\Base\BaseTable;
use App\Tables\Base\Columns\DBString;
use App\Tables\Base\Columns\JSON;

class SiteTable extends BaseTable{

    public string $name = 'site';


    public function construct(){
        $this->columns = [
            new DBString($this,'path'),
            new DBString($this,'filename'),
            new JSON($this,'blueprint'),
        ];
        parent::__construct();
    }
}
