<?php

namespace App\Tables;

use App\Tables\Base\BaseTable;
use App\Tables\Base\Columns\DBString;
use App\Tables\Base\Columns\Date;
use App\Tables\Base\Columns\Time;

class AppointmentTable extends BaseTable
{
    public string $name = 'appointment';

    public function __construct(){
        $this->columns = [
            new DBString($this,'description',['isDisplayValue' => true]),
            new DBString($this,'place'),
            new Time($this,'time'),
            new Date($this,'date')
        ];
        parent::__construct();
    }
}
