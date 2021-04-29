<?php
namespace App\Console\Commands\Utils;

use App\Models\Subject;
use App\Console\Commands\Utils\GenerateModel;

class GenerateController {

    public static function run($subject){

        $uses = "";

        $processData = self::getRelations($subject);

        $validator = self::makeValidation($subject,false);
        $createValidator = $validator[0];
        $uses = $uses.$validator[1];

        /*$makeCreation = self::makeCreation($subject);
        $create = $makeCreation[0];
        $uses = $uses.$makeCreation[1];*/

        $model = GenerateModel::searchForModel($subject->model);

        if($model === false){
            $model = "App\Models\generated\\$subject->model";
        }

        $hidden = GenerateModel::getFields($subject)[1];

return "<?php

namespace App\Http\Controllers\generated;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\MainController;
$uses
class {$subject->model}Controller extends MainController
{
    public function __construct(){
        \$this->model = '$model';
        \$this->table = '$subject->table';
        \$this->createValidation = [$createValidator
        ];
        \$this->hidden = [$hidden];
        parent::__construct();
    }

    function processDataAndRespond(\$array){
        foreach(\$array as &\$data){
            $processData
        }

        return \$this->respond([\$this->table => \$array]);
    }
}";
    }

    public static function getRelations($subject){

        $string = '';

        foreach($subject->attributes as $attribute){

            if($attribute->type !== 'relation'){
                continue;
            }

            $foreign = Subject::where('id',$attribute->relation)->first();

            $foreignClassPath = self::searchForController($foreign->model);
            $foreignClassName = "{$foreign->model}Controller";
            //$foreignClassAlias = $foreignClassName;

            if($foreignClassPath === false){
                $foreignClassPath = "App\Http\Controllers\generated\\";
            }

            /*if($foreign->id === $subject->id){
                $foreignClassAlias = "Manual{$foreign->model}Controller";
            }

            if(! ($foreignClassPath === false && $foreign->id === $subject->id)){

                $use = "use ".$foreignClassPath.$foreignClassName." as ".$foreignClassAlias."; \n";

                if(!in_array($use,$uses)){
                    array_push($uses,$use);
                };
            }*/

            $controller = $foreignClassPath.$foreignClassName;

            $string = $string."
            \$data = \$this->getRelation(\$data,'$attribute->function_name','$controller');";
        }

        /*if(count($uses) > 0){
            $uses = implode('',$uses);
        } else {
            $uses = "//controllers used";
        }*/

        return $string;
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
        $uses = array();

        foreach($subject->attributes as $attribute){
            $part = array();

            if($attribute->type === 'rememberToken'){
                continue;
            }

            if($attribute->required && $nullable === false){
                array_push($part,"'required'");
            } else {
                array_push($part,"'nullable'");
            }

            switch($attribute->type){
                case "password":
                    array_push($uses,"use Illuminate\Validation\Rules\Password;\n");
                    array_push($part,"'string'","Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised()","'confirmed'");
                    break;
                case "relation":
                    if($attribute->relation_type === 'has_many' || $attribute->name === 'creator_id'){
                        continue 2;
                    }

                    $foreign = Subject::where('id',$attribute->relation)->first();
                    array_push($part,"'exists:$foreign->table,id'");
                    break;
                case 'enum':
                    $enum = $attribute->enum;
                    array_push($part,"'in:$enum'");
                    break;
                default:
                    array_push($part,"'$attribute->type'");
            }

            if($attribute->unique){
                array_push($part,"'unique:$subject->table'");
            }

            if($attribute->identifier){
                $identifiers = $subject->attributes->filter(function($value,$key){
                    return $value->identifier == true;
                });

                $use = "use App\Rules\CompositeUnique;\n";

                if(!in_array($use,$uses)){
                    array_push($uses,$use);
                }

                $unique = "";

                foreach($identifiers as $identifier){
                    $unique = $unique."'$identifier->name',";
                }

                $unique = "new CompositeUnique(\$this->table,[$unique])";

                array_push($part,$unique);
            }

            $implode = implode(',',$part);
            $ele = "\t\t\t'$attribute->name' => [$implode], \n";
            $validation = $validation.$ele;
        }

        $uses = implode("",$uses);
        return array($validation,$uses);
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
}
