<?php

namespace App\Http\Validators;
use Illuminate\Support\Facades\Validator;
use App\Helper;

abstract class BaseValidator{

    public $table;
    protected array $userFillable = [];

    public function __construct(){
        $this->userFillable = $this->table->getUserFillable($this->table->getFillable());
    }

    protected function validate($validation,$object){
        //validate the object
        $validator = Validator::make($object,$validation);
        //return the errors if the validation fails
        if($validator->fails()){
            return $validator->errors();
        }

        return true;
    }

    protected function editValidation($entry,$object) : array{
        //get the editValidation of each fillable column of the table
        $validation = [];

        foreach($this->userFillable as $column){
            $validation[$column->getColumnName()] = $column->editValidation($entry,$object);
        }
        return $validation;
    }

    protected function createValidation($object) : array{
        //get the createValidation of each fillable column of the table
        $validation = [];
        foreach($this->userFillable as $column){
            $validation[$column->getColumnName()] = $column->createValidation($object);
        }
        return $validation;
    }

    /*
    public function removeNotFillable($entry){
        $copy = $entry;

        $columns = $this->table->getColumnNames($this->userFillable);

        return Helper::removeNotInArray($copy,$this->table->getColumnNames($this->userFillable));
    }
    */

    public function validateEdit($entry,$object){
        $validation = $this->editValidation($entry,$object);

       //  $validationObject = $this->removeNotFillable($object);

        return $this->validate($validation,$object);
    }

    public function validateCreate($object){
        //create the create validator and validate a given object
        $validation = $this->createValidation($object);

        // $validationObject = $this->removeNotFillable($object);

        return $this->validate($validation,$object);
    }
}
