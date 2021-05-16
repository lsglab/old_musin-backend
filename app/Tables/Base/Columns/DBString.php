<?php

namespace App\Tables\Base\Columns;

class DBString extends Column{

    public function __construct($table,$name,$object=null){
        parent::__construct($table,$name,'string',$object);
    }
}
