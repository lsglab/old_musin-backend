<?php

namespace App\Tables\Base\Columns;
use Illuminate\Database\Schema\Blueprint;

class Integer extends Column{

    public function __construct($table,$name,$object=null){
        parent::__construct($table,$name,$object);
        $this->type = 'integer';
    }

    protected function createDBColumnType(Blueprint $table){
        return $table->integer($this->name);
    }
}
