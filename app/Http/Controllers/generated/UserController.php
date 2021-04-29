<?php

namespace App\Http\Controllers\generated;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\MainController;
use Illuminate\Validation\Rules\Password;

class UserController extends MainController
{
    public function __construct(){
        $this->model = 'App\Models\User';
        $this->table = 'users';
        $this->createValidation = [
			'name' => ['required','string'], 
			'email' => ['required','email','unique:users'], 
			'password' => ['required','string',Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised(),'confirmed'], 
			'role_id' => ['required','exists:roles,id'], 

        ];
        $this->hidden = ['password','remember_token',];
        parent::__construct();
    }

    function processDataAndRespond($array){
        foreach($array as &$data){
            
            $data = $this->getRelation($data,'created_by','App\Http\Controllers\UserController');
            $data = $this->getRelation($data,'roles','App\Http\Controllers\RoleController');
        }

        return $this->respond([$this->table => $array]);
    }
}