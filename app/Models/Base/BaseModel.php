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
        $this->hidden = $this->t_table->hidden;
        $this->fillable = $this->t_table->fillable;
        $this->casts = $this->t_table->casts;
        $this->attributes = $this->t_table->attributes;
        $this->table = $this->t_table->table;

        parent::__construct($attributes);
    }

    public function getRelation($name){
        $relation = array_values(array_filter($this->t_table->relations,function($value) use ($name){
            return $value->getFunctionName() === $name;
        }));

        if(count($relation) > 0){
            $relation = $relation[0];
            $data = $relation->get($this)->values();

            if(count($data) === 1){
                return $data[0];
            }

            return $data;
        }

        return [];
    }
}
