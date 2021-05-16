<?php

namespace App\Tables\Base\Columns;

class Email extends Column{

    public function __construct($table,$name = 'email',$object=null){
        parent::__construct($table,$name,'email',$object);
        $this->unique = true;
    }
}
