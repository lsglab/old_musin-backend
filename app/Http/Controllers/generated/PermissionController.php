<?php

namespace App\Http\Controllers\generated;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Base\MainController;
use Illuminate\Validation\Rule;
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
            $data = $this->getRelation($data,'role','App\Http\Controllers\RoleController');
            $data = $this->getRelation($data,'subject','App\Http\Controllers\SubjectController');
            $data = $this->getRelation($data,'entry_permissions','App\Http\Controllers\EntryPermissionController');
        }

        return $this->respond([$this->table => $array]);
    }

    function create_edit_validation($edit){
        $this->editValidation = [
            
			'action' => ['nullable','in:read,read-self,edit,edit-self,delete,delete-self,create',new CompositeUnique($this->table,['action','role_id','subject_id',])], 
			'role_id' => ['nullable','exists:roles,id',new CompositeUnique($this->table,['action','role_id','subject_id',])], 
			'subject_id' => ['nullable','exists:subjects,id',new CompositeUnique($this->table,['action','role_id','subject_id',])], 

        ];
    }
}