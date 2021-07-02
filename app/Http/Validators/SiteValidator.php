<?php

namespace App\Http\Validators;

use App\Tables\SiteTable;

class SiteValidator extends BaseValidator{

    public function __construct(){
        $this->table = new SiteTable();
        parent::__construct();
    }

    private function customValidation(array $validation) : array{
        //explanation: https://regex101.com/
        //This regex checks for a string to be a valid filepath
        $pathValidation = ['regex:/^\/(?(?=[a-zA-Z\/_])(?!.*(\/)\1+)[a-zA-Z\/_]+\/$|$)/'];
        //This regex checks for a valid filename
        $filenameValidation = ["regex:/^[a-zA-Z1-9_]+.html$/"];

        $validation['path'] = array_merge($validation['path'],$pathValidation);
        $validation['filename'] = array_merge($validation['filename'],$filenameValidation);

        return $validation;
    }

    protected function editValidation($entry,$object) : array{
        $validation = parent::editValidation($entry,$object);
        return $this->customValidation($validation);
    }

    protected function createValidation($object) : array{
        $validation = parent::createValidation($object);
        return $this->customValidation($validation);
    }
}
