<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\MainController;
use App\Tables\RoleTable;
use App\Http\Validators\RoleValidator;
use Illuminate\Database\Eloquent\Builder;

class RoleController extends MainController{

    public function __construct(){
        $this->table = new RoleTable();
        $this->validator = new RoleValidator();
        parent::__construct();
    }

    protected function deleteOne($role) {
        //The Admin and the Public role cannot be deleted
        if($role->name === 'Admin' || $role->name === 'Public') {
            return;
        }

        return parent::deleteOne($component);
    }
}
