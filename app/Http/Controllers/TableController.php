<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Tables\UserTable;
use App\Tables\PermissionTable;
use App\Tables\RoleTable;
use App\Tables\ColumnPermissionTable;
use App\Tables\FileTable;
use App\Tables\SiteTable;
use App\Http\Request\Request;
use App\Http\Controllers\Base\Controller;
use App\Helper;

class TableController extends Controller
{
    protected array $tables = [];
    protected array $actions = ['read','read-self','edit','edit-self','delete','delete-self','create'];
    protected Request $reqeust;

    public function __construct(){
        $this->tables = [
            new UserTable(),
            new RoleTable(),
            new PermissionTable(),
            new FileTable(),
            new ColumnPermissionTable(),
            new SiteTable(),
        ];
        $this->request = new Request();
    }

    protected function respond($array,$status = 200){
        return response()->json($array,$status);
    }

    public function get($table = null){
        if($table === null || $table === false) return $this->tables;

        $filter = array_values(array_filter($this->tables,function($value) use ($table){
            return $value->table === $table;
        }));

        if(count($filter) > 0){
            return $filter[0];
        }

        return null;
    }

    protected function getPermissions(){
        $roleId = auth()->user()->role_id;
        //get all permissions where this role has the read permission
        return Permission::where('role_id',$roleId)
            ->where(function($query){
                $query->where('action','read');
                $query->orWhere('action','read-self');
            })
            ->get();
    }

    protected function read() : array{
        $specific = $this->request->getInput('table');
        $tables = $this->get($specific);
        $permissions = $this->getPermissions();

        if($tables === null) return [];
        if(!is_array($tables)) $tables = array($tables);

        return array_filter($tables,function($table) use ($permissions){
            return $permissions->filter(function($permission) use ($table){
                return $permission->table === $table->table;
            })->count() > 0;
        });

        if(!is_array($tables)) $tables = array($tables);

        return $tables;
    }

    public function handleRead(){
        $data = $this->read();
        return Helper::isResponse($data) ? $data : $this->afterRead($data);
    }

    protected function afterRead($data){
        $data = $this->processData($data);
        return $this->respond(['tables' => $data]);
    }

    protected function processData(array $array) : array{
        $role = auth()->user()->role;

        foreach($array as &$table){

            $permissions = array();

            foreach($this->actions as $action){
                $filter = $role->permissions->filter(function($value,$key) use ($action,$table){
                    return $value->action === $action && $value->table === $table->table;
                });

                if(count($filter) > 0){
                    if($action === 'create'){
                        $permissions[$action] = true;
                    } else {

                        $controller = new $table->controller;
                        $baseAction = explode('-',$action)[0];
                        $controller->builder->request->action = $baseAction;

                        $self = $action === 'edit-self' || $action === 'read-self' || $action === 'delete-self';
                        $ids = array();

                        if($self){
                            $ids = $controller->readSelf(false);
                        } else {
                            $ids = $controller->read(false);
                        }
                        $ids = $ids->map(function($v,$k){
                            return $v->id;
                        });

                        $permissions[$action] = $ids;
                    }
                } else {
                    $permissions[$action] = false;
                }
            }

            $table->editable = $table->getColumnNames($table->getEditable($role,$table->getUserFillable($table->getFillable())));
            $table->permissions = $permissions;
            $table = $table->toArray();
        }

        return $array;
    }
}
