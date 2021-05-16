<?php

namespace App\Tables\Base\Columns;

class Boolean extends Column{

    public function __construct($table,$name,$object=null){
        parent::__construct($table,$name,'boolean',$object);
    }

    public function getCast(){
        return 'boolean';
    }

    public function createDBColumn($table){
        return $table->boolean($name);
    }
}
