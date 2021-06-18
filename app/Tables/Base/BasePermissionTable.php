<?php

namespace App\Tables\Base;

use App\Tables\Base\BaseTable;
use App\Tables\Base\Columns\Enumeration;
use App\Tables\Base\Columns\DBString;
use App\Tables\Base\Columns\Relation\BelongsTo;

class BasePermissionTable extends BaseTable
{
    public ?string $parent = 'App\Tables\RoleTable';

    public function __construct(){
        $this->columns[] =
            new Enumeration($this,'table',
                ['roles','permissions','users','files','column_permissions','sites'],
            ['identifier' => true]);
        $this->relations[] = new BelongsTo($this,'App\Tables\RoleTable','role_id',object: ['identifier' => true]);
        parent::__construct();
    }
}
