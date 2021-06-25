<?php

namespace App\Tables\Base\Columns;

use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;

class JSON extends Column{

    public function __construct($table,$name,$object=null){
        parent::__construct($table,$name,$object);
        $this->type = 'json';
    }

    protected function createDBColumnType(Blueprint $table){
        return $table->json($this->name);
    }

    public function getCast() : string{
        return 'json';
    }
}
