<?php

namespace App\Tables\Base\Columns;
use Illuminate\Database\Schema\Blueprint;

class Boolean extends Column{

    public function __construct($table,$name,$object=null){
        parent::__construct($table,$name,$object);
        $this->type = 'boolean';
    }

    public function getCast() : string{
        return 'boolean';
    }

    public function castValue($value) : bool{
        return $value === 'true' ? true : false;
    }

    protected function createDBColumnType(Blueprint $table){
        return $table->boolean($this->name);
    }
}
