<?php

namespace App\Tables\Base;

use App\Tables\Base\Columns\Relation\BelongsTo;
use App\Tables\Base\Columns\Id;
use App\Tables\Base\Columns\Timestamp;
use App\Tables\User;

class BaseTable extends Table{

    public function __construct($parent = null,$children = []){
        $this->defaultColumns();
        parent::__construct($parent,$children);
    }

    private function defaultColumns(){
        array_push($this->relations,new BelongsTo($this,'App\Tables\UserTable','creator_id','created_by',object: ['required' => false]));
        array_push($this->columns,new Id($this));
        array_push($this->columns,new Timestamp($this,'created_at'));
        array_push($this->columns,new Timestamp($this,'updated_at'));
    }
}
