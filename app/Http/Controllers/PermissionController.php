<?php

/*namespace App\Http\Controllers;

use App\Http\Controllers\generated\PermissionController as GeneratedPermissionController;
use App\Models\generated\Permission;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Builder;

class PermissionController extends GeneratedPermissionController{

    public function __construct(){
        parent::__construct();
    }

    function read($query = null){
        $builder = $this->getDefaultBuilder();

        $builder = $this->queryBuilder($builder,$query);

        $data = $builder->get();
        return $data;
    }

    function getDefaultBuilder(){
        return $this->model::whereHas('subject',function (Builder $query){
            $query->where('parent_id',null);
        });
    }

    function read_self($query = null){
        $role = auth()->user()->role;

        $builder = $this->getDefaultBuilder();

        $builder = $this->queryBuilder($builder,$query);

        return $builder->where('role_id',$role->id)->get();
    }

    function processDataAndRespond($array){
        foreach($array as &$data){
            $data = $this->getRelation($data,'created_by','App\Http\Controllers\UserController');
            $data = $this->getRelation($data,'role','App\Http\Controllers\RoleController');
            $data = $this->getRelation($data,'subject','App\Http\Controllers\SubjectController');
        }

        return $this->respond([$this->table => $array]);
    }

    function findPermission($subject_id,$role_id,$action){
        return Permission::where('subject_id',$subject_id)->where('role_id',$role_id)->where('action',$action)->first();
    }

    function delete_one($entry){
        foreach($entry->subject->children as $child){
            $find = $this->findPermission($child->id,$entry->role_id,$entry->action);

            if($find != null){
                $this->delete_one($find);
            }


            $this->handleExtraActions($child,$entry,function($permission,$subject_id,$role_id,$action){
                if($permission !== null){
                    $permission->delete();
                }
            });
        }
        $entry->delete();
        return $entry;
    }

    function create_one($create){
        $entry = $this->create_permission($create['subject_id'],$create['role_id'],$create['action']);

        $subject = $entry->subject;

        foreach($subject->children as $child){
            $find = $this->findPermission($child->id,$entry->role_id,$entry->action);

            if($find === null){
                $this->create_one([
                    'creator_id' => auth()->user()->id,
                    'action' => $entry->action,
                    'role_id' => $entry->role_id,
                    'subject_id' => $child->id
                ]);
            }


            $this->handleExtraActions($child,$entry,function($permission,$subject_id,$role_id,$action){
                if($permission === null){
                    $this->create_permission($subject_id,$role_id,$action);
                }
            });
        }

        return $entry;
    }

    function create_permission($subject_id,$role_id,$action){
        return Permission::create([
			'creator_id' => auth()->user()->id,
			'action' => $action,
			'role_id' => $role_id,
			'subject_id' => $subject_id,
        ]);
    }

    function handleExtraActions($subject,$entry,$callback){
        $action = explode('-',$entry->action)[0];

        if($action === 'edit'){
            $extraActions = ['create','delete'];

            foreach($extraActions as $extraAction){
                $prefix = "";
                if($entry->action === 'edit-self' && $extraAction !== 'create') $prefix = '-self';

                $permission = $this->findPermission($subject->id,$entry->role_id,$extraAction.$prefix);

                if(is_callable($callback)){
                    $callback($permission,$subject->id,$entry->role_id,$extraAction.$prefix);
                }
            }
        }
    }
}*/
