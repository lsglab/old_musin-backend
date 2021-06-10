<?php

namespace App\Tables;

use App\Tables\Base\BaseTable;
use App\Tables\Base\Columns\Enumeration;
use App\Tables\Base\Columns\DBString;
use App\Tables\Base\Columns\Relation\BelongsTo;

class PermissionTable extends BaseTable
{
    public string $name = 'permission';
    public ?string $parent = 'App\Tables\RoleTable';

    public function __construct(){
        $this->columns = [
            new Enumeration($this,
                'action',['read','read-self','edit','edit-self','delete','delete-self','create'],
                ['identifier' => true]),
            new Enumeration($this,'table',
                ['roles','permissions','users','entry_permissions','files'],
            ['identifier' => true])
        ];
        $this->relations = [
            new BelongsTo($this,'App\Tables\RoleTable','role_id',object: ['identifier' => true]),
        ];
        parent::__construct();
    }
}
