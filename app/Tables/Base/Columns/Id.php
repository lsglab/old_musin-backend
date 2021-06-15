<?php

namespace App\Tables\Base\Columns;
use Illuminate\Database\Schema\Blueprint;

class Id extends Column{

    public function __construct($table,$name = 'id',$object=null){
        parent::__construct($table,$name,$object);
        $this->type = 'id';
        $this->fillable = false;
        $this->userFillable = false;
    }

    protected function getTypeValidation($object) : array{
        return [];
    }

    protected function createDBColumnType(Blueprint $table){
        return $table->id();
    }
}
