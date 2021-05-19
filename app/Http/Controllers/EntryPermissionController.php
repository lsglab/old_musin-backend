<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\MainController;
use App\Tables\EntryPermissionTable;
use App\Models\EntryPermission;
use App\Http\Validators\EntryPermissionValidator;

class EntryPermissionController extends MainController{

    public function __construct(){
        $this->table = new EntryPermissionTable();
        $this->validator = new EntryPermissionValidator();
        parent::__construct();
    }

    function findPermission($table,$role_id,$action,$entry_id){
        return EntryPermission::where('table',$table)
            ->where('role_id',$role_id)
            ->where('action',$action)
            ->where('entry_id',$entry_id)
            ->first();
    }

    private function getChildEntries($table,$child,$foreignEntry){
        $relation = array_values(array_filter($table->relations,function($value) use ($foreignEntry,$child){
            //ignore polymorphic relationships.
            if($value->relation_type !== 'polymorphic_belongs_to' && $value->relation_type !== 'polymorphic_has_many'){
                return $value->getForeignTable($foreignEntry)->table === $child->table;
            }

            return false;
        }));

        if(count($relation) > 0){
            $relation = $relation[0];
            $data = $foreignEntry->getRelation($relation->getFunctionName());
            return $data;
        }

        return false;
    }

    function createOne($create){
        $entry = $this->createPermission($create['table'],$create['role_id'],$create['action'],$create['entry_id']);

        $controller = new TableController();
        $table = $controller->get($entry->table);
        $foreignEntry = $table->model::where('id',$entry->entry_id)->first();

        foreach($table->children as $child){
            $childTable = new $child;

            $childEntries = $this->getChildEntries($table,$childTable,$foreignEntry);

            if($childEntries === false) continue;

            foreach($childEntries as $childEntry){
                $find = $this->findPermission($childTable->table,$entry->role_id,$entry->action,$childEntry->id);

                if($find === null){
                    $this->createOne([
                        'action' => $entry->action,
                        'role_id' => $entry->role_id,
                        'table' => $childTable->table,
                        'entry_id' => $childEntry->id
                    ]);
                }

                $this->handleExtraActions($childTable,$entry,$childEntry,function($permission,$table,$role_id,$action,$entry_id){
                    if($permission === null){
                        $this->createPermission($table,$role_id,$action,$entry_id);
                    }
                });
            }
        }

        return $entry;
    }

    function createPermission($table,$role_id,$action,$entry_id){
        return EntryPermission::create([
			'action' => $action,
			'role_id' => $role_id,
			'table' => $table,
            'entry_id' => $entry_id
        ]);
    }

    function handleExtraActions($table,$entry,$childEntry,$callback){
        $action = explode('-',$entry->action)[0];

        if($action === 'edit'){
            $extraActions = ['delete'];

            foreach($extraActions as $extraAction){

                $permission = $this->findPermission($table->table,$entry->role_id,$extraAction,$childEntry->id);

                if(is_callable($callback)){
                    $callback($permission,$table->table,$entry->role_id,$extraAction,$childEntry->id);
                }
            }
        }
    }
}
