<?php

namespace App\Http\Validators;
use Illuminate\Support\Facades\Validator;

abstract class BaseValidator{

    public $table;

    abstract protected function validate($validation,$object){
        $validator = Validator::make($object,$validation);

        if($validator->fails()){
            return $validator->errors();
        }

        return true;
    }

    abstract protected function validation($object,$required) : array{
        $fillable = $this->table->getFillable();
        $array = [];


    }

    abstract protected function edit_validation($object) : array{

    }

    abstract protected function create_validation($object) : array{

    }

    public function validate_edit($object){
        $validation = $this->create_edit_validation($edit);

        return $this->validateRequest($validation,$object);
    }

    public function validate_create($object){
        $validation = $this->create_create_validation($object);

        return $this->validateRequest($validation,$object);
    }
}
