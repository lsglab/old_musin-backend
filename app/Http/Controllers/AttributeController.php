<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\MainController;
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
            'relation_type' => 'required_with:relation|string|in:has_many,hasMany,belongs_to,belongsTo',
            'enum' => 'required_if:type,enum|string|',
            'function_name' => 'string',
            'unique' => 'boolean',
            'identifier' => 'boolean',
        ];
        parent::__construct();
    }
}
