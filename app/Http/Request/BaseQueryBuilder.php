<?php

namespace App\Http\Request;

use App\Http\Request\Request;

class BaseQueryBuilder extends QueryBuilder{

    public function get($builder = null,$query = null){
        return parent::get($builder,$query);
    }
}
