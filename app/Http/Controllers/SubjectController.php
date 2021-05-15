<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Base\MainController;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Builder;
use App\Console\Commands\Utils\ClassFinder;


class SubjectController extends MainController
{
    public function __construct(){
        parent::__construct();
    }

    public string $model = 'App\Models\Subject';
    public string $table = 'subjects';

    function read($query = null){
        $roleId = auth()->user()->role_id;

        $builder = $this->model::whereHas('permissions',function (Builder $query) use ($roleId){
            $query->where('role_id',$roleId)
                ->where(function($query){
                    $query->where('action','read');
                    $query->orWhere('action','read-self');
                });
        });

        $builder = $this->queryBuilder($builder,$query);

        $data = $builder->get();

        return $data;
    }

    function processDataAndRespond($data){
        $role = auth()->user()->role;

        foreach($data as &$ele){
            $permissions = array();

            foreach($this->actions as $action){
                $filter = $role->permissions->filter(function($value,$key) use ($action,$ele){
                    return $value->action === $action && $value->subject_id === $ele->id;
                });

                if(count($filter) > 0){
                    if($action === 'create'){
                        $permissions[$action] = true;
                    } else {

                        $finder = new ClassFinder();
                        $controller = $finder->searchForController($ele->model);
                        $controller = new $controller;

                        $self = $action === 'edit-self' || $action === 'read-self' || $action === 'delete-self';
                        $ids;

                        if($self){
                            $ids = $controller->read_self(false);
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

            $print = implode(',',$permissions);

            $ele->permissions = $permissions;

            $ele = $this->getRelation($ele,'attributes','App\Http\Controllers\AttributeController',false);
        }

        return $this->respond(['subjects' => $data]);
    }
}
