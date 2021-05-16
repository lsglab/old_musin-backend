<?php

namespace App\Tables\Base\Columns\Relation;
use App\Tables\Base\Columns\Column;

class PolymorphicHasMany extends Relation{

    public function __construct($table,$foreign_table,$name,$function_name,$object = null){
        parent::__construct($table,$foreign_table,$name,'polymorphic_has_many',$function_name,$object);
    }

    private function setFunctionName(){
        $this->function_name = $foreign_table->plural;
    }

    public function getBaseType(){
        return 'has_many';
    }

    public function get($table){
        return $this->morhpMany($this->foreign_table->path,$this->name);
    }
}
