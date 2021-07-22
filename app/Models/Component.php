<?php

namespace App\Models;

use App\Models\Base\MainModel;
use App\Tables\ComponentTable;

class Component extends MainModel{

    public function __construct(array $attributes = []){
        $this->t_table = new ComponentTable();
        parent::__construct($attributes);
    }
}
