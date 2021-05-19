<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\MainController;
use App\Tables\PermissionTable;
use App\Http\Controllers\TableController;
use App\Models\Permission;
use App\Http\Validators\PermissionValidator;
use Illuminate\Database\Eloquent\Builder;

class PermissionController extends MainController{

    public function __construct(){
        $this->table = new PermissionTable();
        $this->validator = new PermissionValidator();
        parent::__construct();
    }

    function findPermission($table,$role_id,$action){
        return Permission::where('table',$table)->where('role_id',$role_id)->where('action',$action)->first();
    }

    function createOne($create){
        $entry = $this->createPermission($create['table'],$create['role_id'],$create['action']);

        $controller = new TableController();
        $table = $controller->get($entry->table);

        foreach($table->children as $child){
            $childTable = new $child;
            $find = $this->findPermission($childTable->table,$entry->role_id,$entry->action);

            if($find === null){
                $this->createOne([
                    'action' => $entry->action,
                    'role_id' => $entry->role_id,
                    'table' => $childTable->table
                ]);
            }

            $this->handleExtraActions($childTable,$entry,function($permission,$table,$role_id,$action){
                if($permission === null){
                    $this->createPermission($table,$role_id,$action);
                }
            });
        }

        return $entry;
    }

    function createPermission($table,$role_id,$action){
        return Permission::create([
			'action' => $action,
			'role_id' => $role_id,
			'table' => $table,
        ]);
    }

    function handleExtraActions($table,$entry,$callback){
        $action = explode('-',$entry->action)[0];

        if($action === 'edit'){
            $extraActions = ['create','delete'];

            foreach($extraActions as $extraAction){
                $prefix = "";
                if($entry->action === 'edit-self' && $extraAction !== 'create') $prefix = '-self';

                $permission = $this->findPermission($table->table,$entry->role_id,$extraAction.$prefix);

                if(is_callable($callback)){
                    $callback($permission,$table->table,$entry->role_id,$extraAction.$prefix);
                }
            }
        }
    }
}
