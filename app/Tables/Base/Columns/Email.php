<?php

namespace App\Tables\Base\Columns;

class Email extends DBString{

    public function __construct($table,$name = 'email',$object=null){
        parent::__construct($table,$name,$object);
        $this->unique = true;
        $this->type = 'email';
    }
}
