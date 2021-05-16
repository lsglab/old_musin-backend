<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use App\Tables\User;

class BaseModel extends Model{

    public $t_table;
    //this is the instance of the Table class
    protected $hidden = [];
    protected $fillable = [];
    protected $casts = [];
    protected $attributes = [];
    //this is the table name, used by eloquent
    protected $table;

    public function __construct(){
        $this->hidden = $this->t_table->hidden;
        $this->fillable = $this->t_table->fillable;
        $this->casts = $this->t_table->casts;
        $this->attributes = $this->t_table->attributes;
        $this->table = $this->t_table->table;

        /*echo "hidden";
        var_dump($this->t_table->hidden);
        echo "fillable";
        var_dump($this->t_table->fillable);
        echo "casts";
        var_dump($this->t_table->casts);
        echo "attributes";
        var_dump($this->t_table->attributes);*/
    }

    public function getRelation($name){
        $relation = array_filter($this->_table->relations,function($value){
            return $value->getFunctionName() === $name;
        });
        if($relation !== undefined){
            return $relation->get($this);
        }
    }
}
