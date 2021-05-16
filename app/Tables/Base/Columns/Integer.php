<?php

namespace App\Tables\Base\Columns;

class Integer extends Column{

    public function __construct($table,$name,$object=null){
        parent::__construct($table,$name,'integer',$object);
    }
}
