<?php

namespace App\Tables;

use App\Tables\Base\BaseTable;
use App\Tables\Base\Columns\Boolean;
use App\Tables\Base\Columns\DBString;
use App\Tables\Base\Columns\Relation\HasMany;
use App\Tables\Base\Columns\Relation\BelongsTo;

class RoleTable extends BaseTable
{
    public string $name = 'role';

    public array $children = ['App\Tables\PermissionTable','App\Tables\ColumnPermissionTable'];

    public function __construct(){
        $this->columns = [
            new DBString($this,'name',['unique' => true]),
            new DBString($this,'description',['required' => false]),
        ];
        $this->relations = [
            new HasMany($this,'App\Tables\UserTable','role_id'),
            new HasMany($this,'App\Tables\PermissionTable','role_id'),
            new HasMany($this,'App\Tables\ColumnPermissionTable','role_id'),
        ];
        parent::__construct();
    }
}
