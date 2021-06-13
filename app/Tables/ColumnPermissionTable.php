<?php

namespace App\Tables;

use App\Tables\Base\BasePermissionTable;
use App\Tables\Base\Columns\Enumeration;
use App\Tables\Base\Columns\DBString;
use App\Tables\Base\Columns\Relation\BelongsTo;

class ColumnPermissionTable extends BasePermissionTable
{
    public string $name = 'column_permission';

    public function __construct(){
        $this->columns = [
            new Enumeration($this,'action',['edit'],['identifier' => true]),
            new DBString($this,'column',['identifier' => true]),
        ];
        parent::__construct();
    }
}
