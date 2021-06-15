<?php

namespace App\Tables\Base\Columns;
use Illuminate\Database\Schema\Blueprint;

class Timestamp extends Column{

    public function __construct($table,$name ,$object=null){
        parent::__construct($table,$name,$object);
        $this->type = 'timestamp';
        $this->fillable = false;
        $this->userFillable = false;
    }

    public function getCast() : string{
        return 'date';
    }

    protected function getTypeValidation($object) : array{
        return ['date'];
    }

    protected function createDBColumnType(Blueprint $table) {
        return $table->timestamp($this->name);
    }
}
