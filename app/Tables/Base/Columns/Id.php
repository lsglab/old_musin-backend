<?php

namespace App\Tables\Base\Columns;

class Id extends Column{

    public function __construct($table,$name = 'id',$object=null){
        parent::__construct($table,$name,'id',$object);
        $this->fillable = false;
    }

    protected function getTypeValidation($object) : array{
        return [];
    }
}
