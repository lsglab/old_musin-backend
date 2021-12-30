<?php

namespace App\Tables;

use App\Tables\Base\BaseTable;
use App\Tables\Base\Columns\DBString;
use App\Tables\Base\Columns\Boolean;
use App\Tables\Base\Columns\JSON;

class ComponentTable extends BaseTable{

    public string $name = 'component';
    public ?string $controller = 'App\Http\Controllers\Frontend\ComponentController';

    public function __construct(){
        $this->columns = [
            new Boolean($this,'slot'),
            new DBString($this,'description'),
            new DBString($this,'name',['unique' => true,'isDisplayColumn' => true]),
            new JSON($this,'blueprint'),
        ];
        parent::__construct();
    }
}
