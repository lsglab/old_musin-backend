<?php

namespace App\Tables\Base\Columns\Relation;
use App\Tables\Base\Columns\Column;
use App\Tables\Base\Columns\DBString;
use Illuminate\Database\Schema\Blueprint;

class PolymorphicBelongsTo extends Relation{

    public string $polymorphic_type;

    public function __construct($table,$name,$functionName,$object = null){
        $this->name = $name."_id";
        $this->polymorphic_type = $name."_type";

        parent::__construct($table,null,$this->name,'polymorphic_belongs_to',$functionName,$object);

        $string = new DBString($this->table,$this->polymorphic_type,['required' => false,'hidden' => true]);
        array_push($this->table->columns,$string);
    }

    public function getForeignTable($entry = null){
        if($entry === null){
            return null;
        }

        $polymorphic_type = $this->polymorphic_type;

        $model = new $entry->$polymorphic_type;

        return $model->t_table;
    }

    public function getBaseType(){
        return 'belongs_to';
    }

    public function get($model){
        return $model->morphTo($this->functionName,$this->polymorphic_type,$this->name);
    }

    protected function createDBColumnType(Blueprint $table){
        return $table->integer($this->name);
    }
}
