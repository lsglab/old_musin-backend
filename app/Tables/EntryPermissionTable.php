<?php

namespace App\Tables;

use App\Tables\Base\BaseTable;
use App\Tables\Base\Columns\Enumeration;
use App\Tables\Base\Columns\DBString;
use App\Tables\Base\Columns\Relation\PolymorphicBelongsTo;
use App\Tables\Base\Columns\Relation\BelongsTo;

class EntryPermissionTable extends BaseTable
{
    public string $name = 'EntryPermission';
    public ?string $parent = 'App\Tables\RoleTable';

    public function __construct(){
        $this->columns = [
            new Enumeration($this,
                'action',['read','edit','delete'],
                ['identifier' => true]),
            new Enumeration($this,'table',
                ['roles','permissions','users','entry_permissions'],
            ['identifier' => true])
        ];
        $this->relations = [
            new PolymorphicBelongsTo($this,'entry_id','entry_type','entry',object: ['identifier' => true]),
            new BelongsTo($this,'App\Tables\RoleTable','role_id',object: ['identifier' => true]),
        ];
        parent::__construct();
    }
}
