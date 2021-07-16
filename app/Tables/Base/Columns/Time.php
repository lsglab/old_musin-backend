<?php

namespace App\Tables\Base\Columns;
use Illuminate\Database\Schema\Blueprint;
use App\Rules\Time as TimeRule;

class Time extends Column{

    public function __construct($table,$name,$object=null){
        parent::__construct($table,$name,$object);
        $this->type = 'time';
    }

    protected function createDBColumnType(Blueprint $table){
        return $table->time($this->name);
    }

    protected function getTypeValidation($object) : array{
        return [new TimeRule];
    }
}
