<?php

namespace App\Tables\Base\Columns;

class Date extends Column{

    public function __construct($table,$name,$object=null){
        parent::__construct($table,$name,'date',$object);
    }

    public function getCast(){
        return 'date';
    }
}
