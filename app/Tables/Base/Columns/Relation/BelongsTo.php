<?php

namespace App\Tables\Base\Columns\Relation;
use App\Tables\Base\Columns\Column;

class BelongsTo extends Relation{

    public function __construct($table,$foreign_table,$name,$function_name = null,$object = null){
        parent::__construct($table,$foreign_table,$name,'belongs_to',$function_name,$object);
    }

    private function setFunctionName(){
        $this->function_name = $foreign_table->name;
    }

    public function getBaseType(){
        return 'belongs_to';
    }

    public function get($table){
        return $table->belongsTo($this->foreign_table->path,$this->name);
    }
}
