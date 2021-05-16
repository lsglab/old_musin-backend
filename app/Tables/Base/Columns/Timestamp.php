<?php

namespace App\Tables\Base\Columns;

class Timestamp extends Column{

    public function __construct($table,$name ,$object=null){
        parent::__construct($table,$name,'timestamp',$object=null);
        $this->fillable = false;
    }

    public function getCast(){
        return 'date';
    }
}
