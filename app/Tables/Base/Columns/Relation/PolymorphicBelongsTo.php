<?php

namespace App\Tables\Base\Columns\Relation;
use App\Tables\Base\Columns\Column;

class PolymorphicBelongsTo extends Relation{

    public string $polymorphic_type;

    public function __construct($table,$name,$polymorphic_type,$function_name,$object = null){
        parent::__construct($table,null,$name,'polymorphic_belongs_to',$function_name,$object);
        $this->polymorphic_type = $polymorphic_type;
    }

    private function setFunctionName(){
        $this->function_name = $function_name;
    }

    public function getBaseType(){
        return 'belongs_to';
    }

    public function get($table){
        return $table->morphTo($this->function_name,$this->polymorphic_type,$this->name);
    }
}
