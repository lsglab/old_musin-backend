<?php

namespace App\Tables;

use App\Tables\Base\BaseTable;
use App\Tables\Base\Columns\DBString;
use App\Tables\Base\Columns\Boolean;
use App\Tables\Base\Columns\JSON;

class SiteTable extends BaseTable{

    public string $name = 'site';


    public function __construct(){
        $this->columns = [
            new DBString($this,'path',['unique' => true]),
            new Boolean($this,'public',['default' => false]),
            new DBString($this,'diskPath',['userFillable' => false,'hidden' => true]),
            new DBString($this,'location',['userFillable' => false ,'hidden' => true]),
            new DBString($this,'url',['userFillable' => false]),
            new DBString($this,'disk',['userFillable' => false,'hidden' => true]),
            new JSON($this,'blueprint'),
        ];
        parent::__construct();
    }
}
