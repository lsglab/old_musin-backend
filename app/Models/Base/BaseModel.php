<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use App\Tables\User;

class BaseModel extends Model implements ModelInterface{
    //this is the instance of the Table class
    public $t_table;
    //protected $attributes = [];
    //this is the table name, used by eloquent

    public function __construct(array $attributes = []){
        ModelFunctions::construct($this);

        parent::__construct($attributes);
    }

    public function getRelation($name){
        return ModelFunctions::getRelation($this,$name);
    }
}
