<?php

namespace App\Tables\Base\Columns\Relation;
use App\Tables\Base\Columns\Column;

class HasMany extends Relation{

    public function __construct($model,$foreign_model,$name,$function_name = null,$object = null){
        parent::__construct($model,$foreign_model,$name,'has_many',$function_name,$object);
    }

    private function setFunctionName(){
        $this->function_name = $foreign_model->plural;
    }

    public function getBaseType(){
        return 'has_many';
    }

    public function get($model){
        return $model->hasMany($this->foreign_model->path,$this->name);
    }
}
