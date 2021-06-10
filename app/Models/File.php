<?php

namespace App\Models;

use App\Models\Base\MainModel;
use App\Tables\FileTable;

class File extends MainModel{

    public function __construct(array $attributes = []){
        $this->t_table = new FileTable();
        parent::__construct($attributes);
    }
}
