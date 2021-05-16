<?php

namespace App\Tables\Base\Columns;

class Enumeration extends Column{

    //this should be an array with the possible options
    public array $enum = [];

    public function __construct($table,$name,$enum,$object=null){
        parent::__construct($table,$name,'enum',$enum,$object=null);
        $this->enum = $enum;
    }
}
