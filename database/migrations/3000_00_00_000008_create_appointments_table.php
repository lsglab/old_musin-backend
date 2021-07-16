<?php

use Database\Base\BaseMigration;
use App\Tables\AppointmentTable;

class CreateAppointmentsTable extends BaseMigration{

    public function __construct(){
        $this->table = new AppointmentTable();
    }
}
