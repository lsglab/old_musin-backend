<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Controllers\Base\MainController;
use App\Models\Permission;
use App\Tables\UserTable;
use App\Tables\PermissionTable;
use App\Tables\RoleTable;
use App\Tables\FileTable;
use App\Tables\EntryPermissionTable;
use Illuminate\Database\Eloquent\Builder;
use App\Console\Commands\Utils\ClassFinder;
use App\Http\Request\Request;
use App\Http\Controllers\Base\Controller;
use App\Helper;

class GroupController extends TableController{

    protected array $groups = [];

    public function __construct(){
        $this->groups = [
            new Group('Authentifizierung',[
                [new UserTable(),'/database/users',],
                [new RoleTable(),'/database/roles',]
            ]),
            new Group('Verwaltung',[
                [new FileTable(),'/media',]
            ])
        ];
        parent::__construct();
    }

    protected function read() : array{
        $specific = $this->request->getInput('table');
        $permissions = $this->getPermissions();

        foreach($this->groups as $group){
            foreach($group->tables as $table){
                $filter = $permissions->filter(function($value,$key) use ($table,$specific){
                    if($specific === false){
                        return $value->table === $table->table;
                    }

                    return $value->table === $table->table && $value->table === $specific;
                });

                if($filter->count() === 0){
                    $group->removeTable($table->table);
                }
            }
        }

        return $this->groups;
    }

    protected function afterRead($data){
        foreach($data as $group){
            $group->tables = $this->processData($group->tables);
        }

        return $this->respond(['groups' => $data]);
    }
}

class Group{

    public string $title;
    public array $tables;
    public array $links;

    public function __construct($title,$tables){
        $this->title = $title;
        foreach($tables as $table){
            $this->tables[$table[0]->table] = $table[0];
            $this->links[$table[0]->table] = $table[1];
        }
    }

    public function removeTable(string $name){
        unset($this->tables[$name]);
        unset($this->links[$name]);
    }
}
