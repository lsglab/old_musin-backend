<?php

namespace App\Tables\Base\Columns;

class Timestamp extends Column{

    public function __construct($table,$name ,$object=null){
        parent::__construct($table,$name,'timestamp',$object);
        $this->fillable = false;
    }

    public function getCast(){
        return 'date';
    }

    protected function getTypeValidation($object) : array{
        return ['date'];
    }
}
