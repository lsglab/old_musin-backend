<?php

namespace App\Tables\Base\Columns;
use Illuminate\Database\Schema\Blueprint;

class Boolean extends Column{

    public function __construct($table,$name,$object=null){
        parent::__construct($table,$name,$object);
        $this->type = 'boolean';
    }

    public function getCast(){
        return 'boolean';
    }

    protected function createDBColumnType(Blueprint $table){
        return $table->boolean($this->name);
    }
}
