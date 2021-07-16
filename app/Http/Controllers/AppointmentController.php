<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\MainController;
use App\Tables\AppointmentTable;
use App\Http\Validators\AppointmentValidator;
use Illuminate\Database\Eloquent\Builder;

class AppointmentController extends MainController{
    public function __construct(){
        $this->table = new AppointmentTable();
        $this->validator = new AppointmentValidator();
        parent::__construct();
    }
}
