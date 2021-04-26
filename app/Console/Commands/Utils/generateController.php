<?php
namespace App\Console\Commands\Utils;

use App\Models\Subject;
use App\Console\Commands\Utils\GenerateModel;

class GenerateController {

    public static function run($subject){

        $relations = GenerateModel::getRelations($subject);
        $uses = $relations[0];

        $process = self::getRelations($subject);
        $processData = $process[0];
        $uses = $uses.$process[1];

        $createValidator = self::makeValidation($subject,false);
        $editValidator = self::makeValidation($subject,true);

        $makeCreation = self::makeCreation($subject);
        $create = $makeCreation[0];
        $uses = $uses.$makeCreation[1];

        $model = GenerateModel::searchForModel($subject->model);

        if($model === false){
            $model = "App\Models\generated\\$subject->model";
        }

        $uses = $uses."use $model; \n";

        $check = self::createDoublesCheck($subject);
return "<?php

namespace App\Http\Controllers\generated;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\MainController;
$uses


class {$subject->model}Controller extends MainController
{

    function read(){
        \$builder = {$subject->model}::where('id','!=',-2);
        \$query = \$this->getQuery();

        if(!\$query){
            \$data = {$subject->model}::all();
        } else {
            \$builder = \$this->queryBuilder(\$builder,{$subject->model}::all()[0]);

            \$data = \$builder->get();
        }

        return \$data;
    }

    function read_self(){
        \$query = \$this->getQuery();
        \$user = auth()->user();

        \$builder = {$subject->model}::where('creator_id',\$user->id);

        if(\$query != false){
            \$builder = \$this->queryBuilder(\$builder,{$subject->model}::all()[0]);
        }

        \$data = \$builder->get();

        return \$data;
    }

    function processDataAndRespond(\$array){
        \$role = auth()->user()->roles;

        foreach(\$array as &\$data){
            $processData
        }

        return \$this->respond(['$subject->table' => \$array]);
    }

    function create(\$create = null){
        if(\$create == null){
            \$create = \$this->request->all();
        }

        \$validate = \$this->validate_create(\$create);

        if(\$validate !== true){
            return \$validate;
        }

        \$body = \$this->getRequestBody();

        $check
        \$created = $subject->model::create([
            $create
        ]);

        return \$created;
    }

    function validate_create(\$object = null){
        if(\$object == null){
            \$object = \$this->request->all();
        }

        \$validator = Validator::make(\$object,[
            $createValidator
        ]);

        if(\$validator->fails()){
            return \$this->respond(\$validator->errors(), 400);
        }

        return true;
    }

    function validate_edit(\$object = null){
        if(\$object == null){
            \$object = \$this->request->all();
        }

        \$validator = Validator::make(\$this->request->all(),[
            $editValidator
        ]);

        if(\$validator->fails()){
            return \$this->respond(\$validator->errors(), 400);
        }

        return true;
    }
}";
    }

    public static function getRelations($subject){

        $string = '';
        $uses = array();

        foreach($subject->attributes as $attribute){

            if($attribute->type !== 'relation'){
                continue;
            }

            $foreign = Subject::where('id',$attribute->relation)->first();

            $foreignClassPath = self::searchForController($foreign->model);
            $foreignClassName = "{$foreign->model}Controller";
            $foreignClassAlias = $foreignClassName;

            if($foreignClassPath === false){
                $foreignClassPath = "App\Http\Controllers\generated\\";
            }

            if($foreign->id === $subject->id){
                $foreignClassAlias = "Manual{$foreign->model}Controller";
            }

            if(! ($foreignClassPath === false && $foreign->id === $subject->id)){

                $use = "use ".$foreignClassPath.$foreignClassName." as ".$foreignClassAlias."; \n";

                if(!in_array($use,$uses)){
                    array_push($uses,$use);
                };
            }

            $string = $string."
        \tif(\$this->getPermission(\$role->id,$foreign->id,'read') !== false){
        \t    \$data->$attribute->function_name;
        \t} else if(\$this->getPermission(\$role->id,$foreign->id,'read-self') !== false){
        \t
        \t    \$foreignClass = new $foreignClassAlias();
        \t    \$self = \$foreignClass->read_self();
        \t    \$return = \$this->getEqualObjects(\$data->$attribute->function_name,\$self);
        \t
        \t    unset(\$data->$attribute->function_name);
        \t    \$data->$attribute->function_name = \$return;
        \t} else {
              \$data->$attribute->function_name = array();
        \t}\n";
        }

        if(count($uses) > 0){
            $uses = implode('',$uses);
        } else {
            $uses = "//controllers used";
        }

        return array($string,$uses);
    }

    public static function searchForController($model){
        $finder = new ClassFinder();
        $classes = $finder->getClassesInFolder('app/Http/Controllers');

        foreach($classes as $class){
            $namespace = "App\Http\Controllers\\{$model}Controller";
            if($class === $namespace){
                return "App\Http\Controllers\\";
            }
        }

        return false;
    }

    public static function makeValidation($subject,$nullable){
        $validation = "\n";

        foreach($subject->attributes as $attribute){
            $part = array();

            if($attribute->type === 'rememberToken'){
                continue;
            }

            if($attribute->required && $nullable === false){
                array_push($part,"required");
            } else {
                array_push($part,"nullable");
            }

            switch($attribute->type){
                case "password":
                    array_push($part,"string","min:8","confirmed");
                    break;
                case "relation":
                    if($attribute->relation_type === 'hasMany' || $attribute->name === 'creator_id'){
                        continue 2;
                    }

                    $foreign = Subject::where('id',$attribute->relation)->first();
                    array_push($part,"exists:$foreign->table,id");
                    break;
                case 'enum':
                    $enum = $attribute->enum;
                    array_push($part,"in:$enum");
                    break;
                default:
                    array_push($part,$attribute->type);
            }

            if($attribute->unique){
                array_push($part,"unique:$subject->table");
            }

            $implode = implode('|',$part);
            $ele = "\t\t\t'$attribute->name' => '$implode', \n";
            $validation = $validation.$ele;
        }

        return $validation;
    }

    public static function makeCreation($subject){
        $create = "\n";
        $uses = "";

        foreach($subject->attributes as $attribute){
            if($attribute->type === 'rememberToken'){
                continue;
            }

            $part = "\$create['$attribute->name']";

            if($attribute->type === 'password'){
                $uses = $uses."use Illuminate\Support\Facades\Hash; \n";
                $part = "Hash::make($part)";
            }

            if($attribute->name === 'creator_id'){
                $part = "auth()->user()->id";
            }

            $create = $create."\t\t\t'$attribute->name' => $part,\n";
        }

        return array($create,$uses);
    }

    public static function createDoublesCheck($subject){
        $identifiers = $subject->attributes->filter(function($value,$key){
            return $value->identifier == true;
        });

        $wheres = array();

        foreach($identifiers as $identifier){
            array_push($wheres,"where('$identifier->name',\$this->request->get('$identifier->name')) \n");
        }

        if(count($identifiers) > 0){
            $wheres = implode("\t\t\t->",$wheres);

            $check = "
        \$duplicate = {$subject->model}::{$wheres}\t\t\t->first();

        if(\$duplicate != null){
            return \$this->respond(['message' => 'entry already exists'],400);
        }
        ";

            return $check;
        } else {
            return "";
        }
    }
}
