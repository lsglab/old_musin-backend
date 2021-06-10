<?php

namespace App\Http\Request;

use App\Http\Request\Request;

class BaseQueryBuilder extends QueryBuilder{

    public function get($builder = null,$query = null){
        $role_id = auth()->user()->role_id;
        $this->setBuilder($builder);

        $baseAction = $this->request->action;

        $hasEntryPermissions = count($this->table->model::whereHas('entry_permissions',function($query) use ($role_id,$baseAction){
            $query->where('role_id',$role_id);
            $query->where('action',$baseAction);
        })->get()) > 0;

        $this->builder = $this->builder->when($hasEntryPermissions,function($query) use($baseAction,$role_id){
            return $query->whereHas('entry_permissions',function($query) use ($baseAction,$role_id){
                $query->where('action',$baseAction);
                $query->where('role_id',$role_id);
            });
        });

        return parent::get($this->builder,$query);
    }
}
