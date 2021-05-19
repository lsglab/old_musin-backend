<?php

namespace App\Http\Validators;
use Illuminate\Support\Facades\Validator;

abstract class BaseValidator{

    public $table;

    protected function validate($validation,$object){
        //validate the object
        $validator = Validator::make($object,$validation);
        //return the errors if the validation fails
        if($validator->fails()){
            return $validator->errors();
        }

        return true;
    }

    protected function editValidation($object) : array{
        //get the editValidation of each fillable column of the table
        $validation = [];
        $fillable = $this->table->getFillable();
        foreach($fillable as $column){
            $validation[$column->getColumnName()] = $column->editValidation($object);
        }
        return $validation;
    }

    protected function createValidation($object) : array{
        //get the createValidation of each fillable column of the table
        $validation = [];
        $fillable = $this->table->getFillable();
        foreach($fillable as $column){
            $validation[$column->getColumnName()] = $column->createValidation($object);
        }
        return $validation;
    }

    public function validateEdit($object){
        //create the editValidator and validate a given object
        $validation = $this->editValidation($object);

        return $this->validate($validation,$object->toArray());
    }

    public function validateCreate($object){
        //create the create validator and validate a given object
        $validation = $this->createValidation($object);

        return $this->validate($validation,$object);
    }
}
