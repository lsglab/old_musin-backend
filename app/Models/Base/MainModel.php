<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use App\Tables\User;

class MainModel extends BaseModel{

    public function created_by(){
        return $this->getRelation(__FUNCTION__);
    }
}
