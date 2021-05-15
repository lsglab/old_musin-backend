<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Base\MainController;
use App\Models\Attribute;
use Illuminate\Database\Eloquent\Builder;
use App\Rules\CompositeUnique;


class AttributeController extends MainController
{
    public function __construct(){

        $this->model = 'App\Models\Attribute';
        $this->table = 'attributes';
        $this->createValidation = [
            'subject_id' => 'required|exists:subjects.id',
            'name' => ['required','string', new CompositeUnique($this->table,['subject_id','name'])],
            'type' => 'string|in:integer,boolean,string,date,password,email,enum,relation',
            'required' => 'boolean',
            'default' => 'string',
            'relation' => 'string|exists:subjects.id',
            'relation_type' => 'required_with:relation|string|in:has_many,belongs_to,polymorphic_belongs_to,polymorphic_has_many',
            'enum' => 'required_if:type,enum|string|',
            'function_name' => 'string',
            'unique' => 'boolean',
            'identifier' => 'boolean',
        ];
        parent::__construct();
    }

    function read($query = false){
        $roleId = auth()->user()->role_id;

        $builder = $this->model::whereHas('subject',function(Builder $query) use ($roleId){
            $query->whereHas('permissions',function (Builder $query) use ($roleId){
                $query->where('role_id',$roleId)
                    ->where(function($query){
                        $query->where('action','read');
                        $query->orWhere('action','read-self');
                    });
            });
        });

        $builder = $this->queryBuilder($builder,$query);

        $data = $builder->get();

        return $data;
    }

    function read_self($query = null){
        return $this->read($query);
    }
}
