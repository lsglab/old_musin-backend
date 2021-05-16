<?php

namespace App\Tables\Base\Columns\Relation;
use App\Tables\Base\Columns\Column;

class PolymorphicBelongsTo extends Relation{

    public string $polymorphic_type;

    public function __construct($table,$name,$polymorphic_type,$functionName,$object = null){
        parent::__construct($table,null,$name,'polymorphic_belongs_to',$functionName,$object);
        $this->polymorphic_type = $polymorphic_type;
    }

    public function getBaseType(){
        return 'belongs_to';
    }

    public function get($model){
        $this->getForeignTable();
        return $model->morphTo($this->functionName,$this->polymorphic_type,$this->name)->get();
    }
}
