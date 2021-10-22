<?php

namespace App\Tables;

use App\Tables\Base\BaseTable;
use App\Tables\Base\Columns\Integer;
use App\Tables\Base\Columns\DBString;
use App\Tables\Base\Columns\Boolean;
use App\Tables\Base\Columns\JSON;

class SiteTable extends BaseTable{

    public string $name = 'site';


    public function __construct(){
        $this->columns = [
            new DBString($this,'path',['unique' => true]),
            new Boolean($this,'public',['default' => false]),
            new JSON($this,'blueprint'),
        ];
        parent::__construct();
    }
}
