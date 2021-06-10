<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use App\Tables\User;

class BaseModel extends Model implements ModelInterface{
    //this is the instance of the Table class
    public $t_table;

    public function __construct(array $attributes = []){
        $this->hidden = ModelFunctions::getHidden($this);
        $this->fillable = ModelFunctions::getFillable($this);
        $this->attributes = ModelFunctions::getAttributes($this);
        $this->casts = ModelFunctions::getCasts($this);
        $this->table = ModelFunctions::getTable($this);
        parent::__construct($attributes);
    }

    public function getRelation($name){
        return ModelFunctions::getRelation($this,$name);
    }
}
