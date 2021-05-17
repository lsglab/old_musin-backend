<?php

namespace App\Tables\Base\Columns;
use Illuminate\Database\Schema\Blueprint;

class DBString extends Column{

    public function __construct($table,$name,$object=null){
        parent::__construct($table,$name,$object);
        $this->type = 'string';
    }

    protected function createDBColumnType(Blueprint $table){
        return $table->string($this->name);
    }
}
