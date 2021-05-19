<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Controllers\Base\MainController;
use App\Models\Permission;
use App\Tables\UserTable;
use App\Tables\PermissionTable;
use App\Tables\RoleTable;
use App\Tables\EntryPermissionTable;
use Illuminate\Database\Eloquent\Builder;
use App\Console\Commands\Utils\ClassFinder;
use App\Http\Request\Request;
use App\Http\Controllers\Base\Controller;
use App\Helper;

class TableController extends Controller
{
    public array $tables;
    private array $actions = ['read','read-self','edit','edit-self','delete','delete-self','create'];
    private Request $reqeust;

    public function __construct(){
        $this->groups = [
            new Group('Authentifizierung',[
                new UserTable(),
                new PermissionTable(),
                new RoleTable(),
                new EntryPermissionTable(),
            ])
        ];
        $this->request = new Request();
    }

    protected function respond($array,$status = 200){
        return response()->json($array,$status);
    }

    public function get($table = null){
        $tables = array();

        foreach($this->groups as $group){
            $tables = array_values(array_merge($tables,$group->tables));
        }

        if($table !== null){
            $filter = array_values(array_filter($tables,function($value) use ($table){
                return $value->table === $table;
            }));

            if(count($filter) > 0){
                return $filter[0];
            }

            return null;
        }

        return $tables;
    }

    protected function read($query = null){
        $roleId = auth()->user()->role_id;
        //get all permissions where this role has the read permission
        $permissions = Permission::where('role_id',$roleId)
            ->where(function($query){
                $query->where('action','read');
                $query->orWhere('action','read-self');
            })
            ->get();

        $specific = $query['table'] || $this->request->getInput('table');

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

    public function handleRead(){
        $data = $this->read();
        return Helper::isResponse($data) ? $data : $this->afterRead($data);
    }

    protected function afterRead($data){
        return $this->processDataAndRespond($data);
    }

    protected function processDataAndRespond($data){
        $role = auth()->user()->getRelation('role');

        foreach($data as $group){
            foreach($group->tables as &$table){
                $permissions = array();

                foreach($this->actions as $action){
                    $filter = $role->getRelation('permissions')->filter(function($value,$key) use ($action,$table){
                        return $value->action === $action && $value->table === $table->table;
                    });

                    if(count($filter) > 0){
                        if($action === 'create'){
                            $permissions[$action] = true;
                        } else {

                            $controller = new $table->controller;

                            $self = $action === 'edit-self' || $action === 'read-self' || $action === 'delete-self';
                            $ids;

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

                $table->permissions = $permissions;
            }

            foreach($group->tables as &$ele){
                $ele = $ele->toArray();
            }

        }

        if($this->request->getInput('group') === false){
            $data = array_map(function($value){
                return $value->tables;
            },$data);
        }

        return $this->respond(['tables' => $data]);
    }
}

class Group{

    public string $title;
    public array $tables;

    public function __construct($title,$tables){
        $this->title = $title;
        foreach($tables as $table){
            $this->tables[$table->table] = $table;
        }
    }

    public function removeTable(string $name){
        unset($this->tables[$name]);
    }
}
