<?php

namespace App\Tables\Base\Columns;
use Illuminate\Database\Schema\Blueprint;

class RememberToken extends Column{

    public function __construct($table,$name = 'remember_token',$object=null){
        parent::__construct($table,$name,$object);
        $this->type = 'rememberToken';
        $this->hidden = true;
        $this->userFillable = false;
        $this->fillable = false;
    }

    protected function getTypeValidation($object) : array{
        return [];
    }

    protected function createDBColumnType($table){
        return $table->rememberToken();
    }
}
