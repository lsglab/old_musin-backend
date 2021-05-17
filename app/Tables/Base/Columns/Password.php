<?php

namespace App\Tables\Base\Columns;
use Illuminate\Support\Facades\Hash;

class Password extends DBString{

    public function __construct($table,$name = 'password',$object=null){
        parent::__construct($table,$name,$object);
        $this->type = 'password';
        $this->hidden = true;
    }

    protected function getTypeValidation($object) : array{
        return ['string','min:8','confirmed'];
    }

    public function modifyValue($value){
        return Hash::make($value);
    }
}
