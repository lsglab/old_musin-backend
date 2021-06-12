<?php

namespace App\Tables;

use App\Tables\Base\BaseTable;
use App\Tables\Base\Columns\Enumeration;
use App\Tables\Base\Columns\DBString;
use App\Tables\Base\Columns\Integer;
use App\Tables\Base\Columns\Boolean;
use App\Tables\Base\Columns\Relation\BelongsTo;

class FileTable extends BaseTable
{
    public string $name = 'file';

    public function __construct(){
        $this->columns = [
            new DBString($this,'name',['unique' => true]),
            new DBString($this,'url',['required' => false]),
            new Integer($this,'size'),
            new Enumeration($this,'type',['image/jpeg','image/png']),
            new Boolean($this,'public'),
            new DBString($this,'disk',['hidden' => true,'required' => false]),
            new DBString($this,'path',['hidden' => true,'required' => false]),
            new DBString($this,'location',['hidden' => true,'required' => false]),
            new DBString($this,'description',['required' => false,'default' => ''])
        ];
        parent::__construct();
    }
}
