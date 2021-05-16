<?php

namespace App\Tables\Base;

use App\Tables\Base\Columns\Relation\BelongsTo;
use App\Tables\Base\Columns\Id;
use App\Tables\Base\Columns\Timestamp;
use App\Tables\User;

class BaseTable extends Table{

    public function __construct($parent = null,$children = []){
        parent::__construct($parent,$children);
        $this->defaultColumns();
    }

    private function defaultColumns(){
        $this->relations[] = new BelongsTo($this,'App\Tables\User','creator_id','created_by');
        $this->columns[] = new Id($this);
        $this->columns[] = new Timestamp($this,'created_at');
        $this->columns[] = new Timestamp($this,'updated_at');
    }
}
