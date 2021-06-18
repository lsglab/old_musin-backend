<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\MainController;
use App\Tables\SiteTable;
use App\Http\Validators\SiteValidator;

class SiteController extends MainController{
    public function __construct(){
        $this->table = new SiteTable();
        $this->validator = new SiteValidator();
        parent::__construct();
    }
}
