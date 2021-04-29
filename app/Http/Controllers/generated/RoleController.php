<?php

namespace App\Http\Controllers\generated;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\MainController;

class RoleController extends MainController
{
    public function __construct(){
        $this->model = 'App\Models\generated\Role';
        $this->table = 'roles';
        $this->createValidation = [
			'name' => ['required','string'], 
			'description' => ['nullable','string'], 
			'admin' => ['required','boolean'], 

        ];
        $this->hidden = [];
        parent::__construct();
    }

    function processDataAndRespond($array){
        foreach($array as &$data){
            
            $data = $this->getRelation($data,'created_by','App\Http\Controllers\UserController');
            $data = $this->getRelation($data,'permissions','App\Http\Controllers\PermissionController');
            $data = $this->getRelation($data,'users','App\Http\Controllers\UserController');
        }

        return $this->respond([$this->table => $array]);
    }
}