<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\MainController;
use App\Tables\UserTable;
use App\Http\Validators\UserValidator;
use Illuminate\Database\Eloquent\Builder;

class UserController extends MainController{
    public function __construct(){
        $this->table = new UserTable();
        $this->validator = new UserValidator();
        parent::__construct();
    }
}
