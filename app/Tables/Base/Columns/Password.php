<?php

namespace App\Tables\Base\Columns;

class Password extends Column{

    public function __construct($table,$name = 'password',$object=null){
        parent::__construct($table,$name,'password',$object=null);
        $this->hidden = true;
    }
}
