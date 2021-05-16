<?php

namespace App\Tables;

use App\Tables\Base\BaseTable;
use App\Tables\Base\Columns\Email;
use App\Tables\Base\Columns\Password;
use App\Tables\Base\Columns\DBString;
use App\Tables\Base\Columns\RememberToken;
use App\Tables\Base\Columns\Relation\BelongsTo;

class UserTable extends BaseTable
{
    public string $name = 'user';

    public string $rememberTokenName = 'remember_token';

    public function __construct(){
        $this->columns = [
            new Email($this),
            new DBString($this,'name',['unique' => true]),
            new Password($this),
            new RememberToken($this,$this->rememberTokenName)
        ];
        $this->relations = [
            new BelongsTo($this,'App\Tables\RoleTable','role_id'),
        ];
        parent::__construct();
    }
}
