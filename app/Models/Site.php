<?php

namespace App\Models;

use App\Models\Base\MainModel;
use App\Tables\SiteTable;

class Site extends MainModel{

    public function __construct(array $attributes = []){
        $this->t_table = new SiteTable();
        parent::__construct($attributes);
    }
}
