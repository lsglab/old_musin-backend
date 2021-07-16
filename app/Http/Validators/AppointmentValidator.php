<?php

namespace App\Http\Validators;

use App\Tables\AppointmentTable;

class AppointmentValidator extends BaseValidator{

    public function __construct(){
        $this->table = new AppointmentTable();
        parent::__construct();
    }
}
