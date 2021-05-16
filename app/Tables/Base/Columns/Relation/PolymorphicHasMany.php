<?php

namespace App\Tables\Base\Columns\Relation;
use App\Tables\Base\Columns\Column;

class PolymorphicHasMany extends Relation{

    public function __construct($table,$foreignTable,$name,$functionName,$object = null){
        parent::__construct($table,$foreignTable,$name,'polymorphic_has_many',$functionName,$object);
    }

    protected function setFunctionName(){
        $this->functionName = $this->foreignTable->plural;
    }

    public function getBaseType(){
        return 'has_many';
    }

    public function get($model){
        $this->getForeignTable();
        return $model->morhpMany($this->foreignTable->model,$this->name)->get();
    }
}
