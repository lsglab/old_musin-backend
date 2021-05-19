<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use App\Tables\EntryPermissionTable;

class EntryPermission extends BaseModel{

    public function __construct(array $attributes = []){
        $this->t_table = new EntryPermissionTable();
        parent::__construct($attributes);
    }
}
