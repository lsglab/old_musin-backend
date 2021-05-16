<?php

namespace App\Tables\Base\Columns\Relation;
use App\Tables\Base\Columns\Column;

class BelongsTo extends Relation{

    public function __construct($table,$foreignTable,$name,$functionName = null,$object = null){
        parent::__construct($table,$foreignTable,$name,'belongs_to',$functionName,$object);
    }

    protected function setFunctionName(){
        $this->functionName = $this->foreignTable->name;
    }

    public function getBaseType(){
        return 'belongs_to';
    }

    public function get($model){
        $this->getForeignTable();
        return $model->belongsTo($this->foreignTable->model,$this->name)->get();
    }

    protected function getTypeValidation($object) : array{
        $this->getForeignTable();
        $string = "exists:".$this->foreignTable->table.",id";
        return [$string];
    }
}
