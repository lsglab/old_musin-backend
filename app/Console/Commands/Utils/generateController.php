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

        $validator = self::makeValidation($subject,true);
        $editValidator = $validator[0];

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
use App\Http\Controllers\Base\MainController;
use Illuminate\Validation\Rule;
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

    function create_edit_validation(\$edit){
        \$this->editValidation = [
            $editValidator
        ];
    }
}";
    }

    public static function getRelations($subject){

        $string = '';

        foreach($subject->attributes as $attribute){

            if($attribute->type !== 'relation' || $attribute->relation_type === 'polymorphic_belongs_to'){
                continue;
            }

            $foreign = Subject::where('id',$attribute->relation)->first();

            $finder = new ClassFinder();

            $controller = $finder->searchForController($foreign->model);

            $string = $string."
            \$data = \$this->getRelation(\$data,'$attribute->function_name','$controller');";
        }

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

    public static function makeValidation($subject,$edit){
        $validation = "\n";
        $uses = array();

        foreach($subject->attributes as $attribute){
            $part = array();

            if($attribute->type === 'timestamp' || $attribute->type === 'id'){
                continue;
            }

            if($attribute->required && $edit === false){
                array_push($part,"'required'");
            } else {
                array_push($part,"'nullable'");
            }

            switch($attribute->type){
                case "password":
                    //array_push($uses,"use Illuminate\Validation\Rules\Password;\n");
                    array_push($part,"'string'","'min:8'","'confirmed'");
                    break;
                case "relation":
                    if($attribute->relation_type === 'has_many' || $attribute->name === 'creator_id' || $attribute->relation_type === 'polymorphic_belongs_to' || $attribute->relation_type === 'polymorphic_has_many'){
                        continue 2;
                    }

                    $foreign = Subject::where('id',$attribute->relation)->first();
                    array_push($part,"'exists:$foreign->table,id'");
                    break;
                case 'enum':
                    $enum = $attribute->enum;
                    array_push($part,"'in:$enum'");
                    break;
                case 'polymorphic_type':
                    array_push($part,"'string'");
                    break;
                default:
                    array_push($part,"'$attribute->type'");
            }

            if($attribute->unique){
                if($edit){
                    array_push($part,"Rule::unique('$subject->table')->ignore(\$edit->id)");
                } else {
                    array_push($part,"'unique:$subject->table'");
                }
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
