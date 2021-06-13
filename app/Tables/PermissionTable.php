<?php

namespace App\Tables;

use App\Tables\Base\BasePermissionTable;
use App\Tables\Base\Columns\Enumeration;
use App\Tables\Base\Columns\Relation\BelongsTo;

class PermissionTable extends BasePermissionTable
{
    public string $name = 'permission';

    public function __construct(){
        $this->columns = [
            new Enumeration($this,
                'action',['read','read-self','edit','edit-self','delete','delete-self','create'],
                ['identifier' => true]),
        ];
        parent::__construct();
    }
}
