<?php

namespace App\Tables;

use App\Tables\Base\BaseTable;
use App\Tables\Base\Columns\Enumeration;
use App\Tables\Base\Columns\DBString;
use App\Tables\Base\Columns\Relation\BelongsTo;

class Permission extends BaseTable
{
    public $path = 'App\Models\Permission';
    public $name = 'permission';

    public function __construct(){
        $this->columns = [
            new Enumeration($this,
                'action',['read','read-self','edit','edit-self','delete','delete-self','create'],
                ['identifier' => true]),
            new DBString($this,'table',['identifier' => true])
        ];
        $this->relations = [
            new BelongsTo($this,'App\Tables\Role','role_id',['identifier' => true]),
        ];
        parent::__construct();
    }
}
