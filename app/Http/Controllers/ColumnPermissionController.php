<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\MainController;
use App\Tables\ColumnPermissionTable;
use App\Http\Validators\ColumnPermissionValidator;
use Illuminate\Database\Eloquent\Builder;

class ColumnPermissionController extends MainController{
    public function __construct(){
        $this->table = new ColumnPermissionTable();
        $this->validator = new ColumnPermissionValidator();
        parent::__construct();
    }
}
