<?php

namespace App\Models;

use App\Models\Base\MainModel;
use App\Tables\AppointmentTable;

class Appointment extends MainModel{

    public function __construct(array $attributes = []){
        $this->t_table = new AppointmentTable();
        parent::__construct($attributes);
    }
}
