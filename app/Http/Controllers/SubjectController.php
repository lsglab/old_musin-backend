<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\MainController;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Builder;


class SubjectController extends MainController
{
    public string $model = 'App\Models\Subject';
    public string $table = 'subjects';

    function read(){
        $query = $this->getQuery();
        $roleId = auth()->user()->role_id;

        $builder = $this->model::whereNull('parent_id')->whereHas('permissions',function (Builder $query) use ($roleId){
            $query->where('role_id',$roleId)
                ->where('action','read');
        });

        $builder = $this->queryBuilder($builder);

        $data = $builder->get();

        return $data;
    }

    function processDataAndRespond($data){
        $role = auth()->user()->roles;

        foreach($data as $ele){
            $permissions = array();

            foreach($this->actions as $action){
                $filter = $role->permissions->filter(function($value,$key) use ($action,$ele){
                    return $value->action === $action && $value->subject_id === $ele->id;
                });

                if(count($filter) > 0){
                    $permissions[$action] = true;
                } else {
                    $permissions[$action] = false;
                }
            }

            $print = implode(',',$permissions);

            $ele->permissions = $permissions;
        }
        return $this->respond(['subjects' => $data]);
    }
}
