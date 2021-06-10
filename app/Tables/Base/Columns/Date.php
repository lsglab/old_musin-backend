<?php

namespace App\Tables\Base\Columns;
use Illuminate\Database\Schema\Blueprint;

class Date extends Column{

    public function __construct($table,$name,$object=null){
        parent::__construct($table,$name,$object);
        $this->type = 'date';
    }

    public function getCast() : string{
        return 'date';
    }

    protected function createDBColumnType(Blueprint $table){
        return $table->date($this->name);
    }
}
