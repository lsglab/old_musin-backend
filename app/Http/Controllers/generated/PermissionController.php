<?php

namespace App\Http\Controllers\generated;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\MainController;
use App\Rules\CompositeUnique;

class PermissionController extends MainController
{
    public function __construct(){
        $this->model = 'App\Models\generated\Permission';
        $this->table = 'permissions';
        $this->createValidation = [
			'action' => ['required','in:read,read-self,edit,edit-self,delete,delete-self,create',new CompositeUnique($this->table,['action','role_id','subject_id',])], 
			'role_id' => ['required','exists:roles,id',new CompositeUnique($this->table,['action','role_id','subject_id',])], 
			'subject_id' => ['required','exists:subjects,id',new CompositeUnique($this->table,['action','role_id','subject_id',])], 

        ];
        $this->hidden = [];
        parent::__construct();
    }

    function processDataAndRespond($array){
        foreach($array as &$data){
            
            $data = $this->getRelation($data,'created_by','App\Http\Controllers\UserController');
            $data = $this->getRelation($data,'roles','App\Http\Controllers\RoleController');
            $data = $this->getRelation($data,'subjects','App\Http\Controllers\SubjectController');
        }

        return $this->respond([$this->table => $array]);
    }
}