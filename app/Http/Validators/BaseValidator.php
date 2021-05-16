<?php

namespace App\Http\Validators;
use Illuminate\Support\Facades\Validator;

abstract class BaseValidator{

    public $table;

    protected function validate($validation,$object){
        $validator = Validator::make($object,$validation);

        if($validator->fails()){
            return $validator->errors();
        }

        return true;
    }

    protected function editValidation($object) : array{
        $validation = [];
        $fillable = $this->table->getFillable();
        foreach($fillable as $column){
            $validation[$column->getDatabaseColumnName()] = $column->editValidation($object);
        }
        return $validation;
    }

    protected function createValidation($object) : array{
        $validation = [];
        $fillable = $this->table->getFillable();
        foreach($fillable as $column){
            $validation[$column->getDatabaseColumnName()] = $column->createValidation($object);
        }
        return $validation;
    }

    public function validateEdit($object){
        $validation = $this->editValidation($object);

        return $this->validate($validation,$object->toArray());
    }

    public function validateCreate($object){
        $validation = $this->createValidation($object);

        return $this->validate($validation,$object);
    }
}
