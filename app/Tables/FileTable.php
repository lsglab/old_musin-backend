<?php

namespace App\Tables;

use App\Tables\Base\BaseTable;
use App\Tables\Base\Columns\Enumeration;
use App\Tables\Base\Columns\DBString;
use App\Tables\Base\Columns\Integer;
use App\Tables\Base\Columns\Relation\BelongsTo;

class FileTable extends BaseTable
{
    public string $name = 'file';

    public function __construct(){
        $this->columns = [
            new DBString($this,'name',['unique' => true]),
            new DBString($this,'path',['required' => false]),
            new Integer($this,'size'),
            new DBString($this,'type'),
            new DBString($this,'description',['required' => false,'default' => ''])
        ];
        parent::__construct();
    }
}
