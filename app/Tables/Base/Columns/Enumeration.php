<?php

namespace App\Tables\Base\Columns;

class Enumeration extends DBString{

    //this should be an array with the possible options
    public array $enum = [];

    public function __construct($table,$name,$enum,$object=null){
        parent::__construct($table,$name,$object);
        $this->type = 'enum';
        $this->enum = $enum;
    }

    protected function getTypeValidation($object) : array{
        $options = implode(',',$this->enum);
        $string = "in:$options";
        return [$string];
    }
}
