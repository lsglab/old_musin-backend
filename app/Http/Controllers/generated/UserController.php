<?php

namespace App\Http\Controllers\generated;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Base\MainController;
use Illuminate\Validation\Rule;

class UserController extends MainController
{
    public function __construct(){
        $this->model = 'App\Models\User';
        $this->table = 'users';
        $this->createValidation = [
			'name' => ['required','string'], 
			'email' => ['required','email','unique:users'], 
			'password' => ['required','string','min:8','confirmed'], 
			'role_id' => ['required','exists:roles,id'], 

        ];
        $this->hidden = ['password','remember_token',];
        parent::__construct();
    }

    function processDataAndRespond($array){
        foreach($array as &$data){
            
            $data = $this->getRelation($data,'created_by','App\Http\Controllers\UserController');
            $data = $this->getRelation($data,'role','App\Http\Controllers\RoleController');
            $data = $this->getRelation($data,'entry_permissions','App\Http\Controllers\EntryPermissionController');
        }

        return $this->respond([$this->table => $array]);
    }

    function create_edit_validation($edit){
        $this->editValidation = [
            
			'name' => ['nullable','string'], 
			'email' => ['nullable','email',Rule::unique('users')->ignore($edit->id)], 
			'password' => ['nullable','string','min:8','confirmed'], 
			'role_id' => ['nullable','exists:roles,id'], 

        ];
    }
}