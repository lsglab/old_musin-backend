<?php

namespace App\Tables;

use App\Tables\Base\BaseTable;
use App\Tables\Base\Columns\Boolean;
use App\Tables\Base\Columns\DBString;
use App\Tables\Base\Columns\Relation\HasMany;
use App\Tables\Base\Columns\Relation\BelongsTo;

class Role extends BaseTable
{
    public string $path = 'App\Models\Role';
    public string $name = 'role';

    public function __construct(){
        $this->columns = [
            new DBString($this,'name',['unique' => true]),
            new DBString($this,'description',['required' => false]),
        ];
        $this->relations = [
            new Boolean($this,'role',['required' => false]),
            new HasMany($this,'App\Tables\User','role_id'),
        ];
        parent::__construct();
    }
}
