<?php

namespace App\Tables\Base\Columns\Relation;
use App\Tables\Base\Columns\Column;

class HasMany extends Relation{

    public function __construct($model,$foreignTable,$name,$functionName = null,$object = null){
        parent::__construct($model,$foreignTable,$name,'has_many',$functionName,$object);
        $this->fillable = false;
    }

    protected function setFunctionName(){
        $this->functionName = $this->foreignTable->plural;
    }

    public function getBaseType(){
        return 'has_many';
    }

    public function get($model){
        $this->getForeignTable();
        $data = $model->hasMany($this->foreignTable->model,$this->name)->get();

        return $data;
    }
}
