<?php

namespace App\Http\Controllers\generated;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Base\MainController;
use Illuminate\Validation\Rule;

class RoleController extends MainController
{
    public function __construct(){
        $this->model = 'App\Models\generated\Role';
        $this->table = 'roles';
        $this->createValidation = [
			'name' => ['required','string'], 
			'description' => ['nullable','string'], 
			'admin' => ['nullable','boolean'], 

        ];
        $this->hidden = [];
        parent::__construct();
    }

    function processDataAndRespond($array){
        foreach($array as &$data){
            
            $data = $this->getRelation($data,'created_by','App\Http\Controllers\UserController');
            $data = $this->getRelation($data,'permissions','App\Http\Controllers\PermissionController');
            $data = $this->getRelation($data,'users','App\Http\Controllers\UserController');
            $data = $this->getRelation($data,'entry_permissions_by_role','App\Http\Controllers\EntryPermissionController');
            $data = $this->getRelation($data,'entry_permissions','App\Http\Controllers\EntryPermissionController');
        }

        return $this->respond([$this->table => $array]);
    }

    function create_edit_validation($edit){
        $this->editValidation = [
            
			'name' => ['nullable','string'], 
			'description' => ['nullable','string'], 
			'admin' => ['nullable','boolean'], 

        ];
    }
}