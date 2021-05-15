<?php

namespace App\Http\Controllers;

use App\Http\Controllers\generated\EntryPermissionController as GeneratedEntryPermissionController;
use App\Models\generated\EntryPermission;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Builder;
use App\Console\Commands\Utils\ClassFinder;

class EntryPermissionController extends GeneratedEntryPermissionController{

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
        $finder = new ClassFinder();

        foreach($array as &$data){
            $subject = Subject::find($data->subject_id);
            $data = $this->getRelation($data,'created_by','App\Http\Controllers\UserController');
            $data = $this->getRelation($data,'role','App\Http\Controllers\RoleController');
            $data = $this->getRelation($data,'subject','App\Http\Controllers\SubjectController');
            $data = $this->getRelation($data,'entry',$finder->searchForController($subject->model));
        }

        return $this->respond([$this->table => $array]);
    }

    function findPermission($subject_id,$role_id,$action,$entry_id){
        return $this->model::where('subject_id',$subject_id)->where('role_id',$role_id)->where('action',$action)->where('entry_id',$entry_id)->first();
    }

    function delete_one($entry){
        $subject = $entry->subject;

        foreach($subject->children as $child){
            $relation = $this->get_relation($subject,$child->id);

            $function_name = $relation->function_name;
            $values = $subject->$function_name;

            foreach($values as $value){
                $find = $this->findPermission($child->id,$entry->role_id,$entry->action,$value->id);

                if($find != null){
                    $this->delete_one($find);
                }

                $this->handleExtraActions($child,$entry,function($permission,$subject_id,$role_id,$action,$entry_id){
                    if($permission !== null){
                        $permission->delete();
                    }
                });
            }
        }
        $entry->delete();
        return $entry;
    }

    function get_relation($subject,$relation_id){
        return array_values($subject->attributes->filter(function($value,$key) use ($relation_id){
            /*if($value->relation_type === 'polymorphic_belongs_to'){
                $foreign = Subject::find($relation_id);
                if($foreign->attributes->filter(function($attribute,$k) {
                    $attribute->relation ===
                }) !== null){

                }
            }*/
            return $value->relation === $relation_id;
        })->all())[0];
    }

    function create_one($create){
        $entry = $this->create_permission($create['subject_id'],$create['role_id'],$create['action'],$create['entry_id']);
        $subject = $entry->subject;

        foreach($subject->children as $child){
            $relation = $this->get_relation($subject,$child->id);
            $function_name = $relation->function_name;

            $values = $subject->$function_name;

            if($values === null){
                continue;
            }

            foreach($values as $value){
                $find = $this->findPermission($child->id,$entry->role_id,$entry->action,$value->id);

                if($find === null){
                    $this->create_one([
                        'creator_id' => auth()->user()->id,
                        'action' => $entry->action,
                        'role_id' => $entry->role_id,
                        'subject_id' => $child->id,
                        'entry_id' => $value->id,
                    ]);
                }

                $this->handleExtraActions($child,$entry,function($permission,$subject_id,$role_id,$action,$entry_id){
                    if($permission === null){
                        $this->create_permission($subject_id,$role_id,$action,$entry_id);
                    }
                });
            }
        }

        return $entry;
    }

    function create_permission($subject_id,$role_id,$action,$entry_id){
        return $this->model::create([
			'creator_id' => auth()->user()->id,
			'action' => $action,
			'role_id' => $role_id,
			'subject_id' => $subject_id,
            'entry_id' => $entry_id
        ]);
    }

    function handleExtraActions($subject,$entry,$callback){
        $action = explode('-',$entry->action)[0];

        if($action === 'edit'){
            $extraActions = ['create','delete'];

            foreach($extraActions as $extraAction){

                $permission = $this->findPermission($subject->id,$entry->role_id,$extraAction,$entry->entry_id);

                if(is_callable($callback)){
                    $callback($permission,$subject->id,$entry->role_id,$extraAction,$entry->entry_id);
                }
            }
        }
    }
}
