<?php
namespace App\Console\Commands\Utils;

use App\Models\Subject;

class GenerateModel {

    public static function run($subject){

        $fields = self::getFields($subject);
        $fillable = $fields[0];
        $hidden = $fields[1];

        $relations = self::getRelations($subject);
        $uses = $relations[0];
        $functions = $relations[1];

        $attributes = self::getDefaults($subject);

        $extends = "Model";

        if($subject->authenticatable == true){
            $extends = "Authenticatable";
            $uses = $uses."
            use Illuminate\Foundation\Auth\User as Authenticatable; \n
            ";
        }

        return "<?php

        namespace App\Models\generated;

        use Illuminate\Database\Eloquent\Factories\HasFactory;
        use Illuminate\Database\Eloquent\Model;
        $uses

        class $subject->model extends $extends
        {
            use HasFactory;

            protected \$fillable = [$fillable];
            protected \$hidden = [$hidden];
            protected \$attributes = [$attributes];

            $functions
        }";
    }

    public static function getFields($subject){
        $fillable = "";
        $hidden = "";

        foreach($subject->attributes as $attribute){
            $string = "";

            if($attribute->relation_type === 'hasMany'){
                continue;
            }

            if($attribute->type === 'password' || $attribute->type === 'rememberToken'){
                $string = $string."'$attribute->name'".',';
                $hidden = $hidden.$string;
            }

            if($attribute->type !== 'rememberToken'){
                $string = $string."'$attribute->name'".',';
                $fillable = $fillable.$string;
            }
        }

        return array($fillable,$hidden);
    }

    public static function getRelations($subject){
        $functions = "//relationships: \n";
        $uses = array();

        foreach($subject->attributes as $attribute){
            if($attribute->type === 'relation'){
                $foreign = Subject::where('id',$attribute->relation)->first();

                $inFunction = "$foreign->model::class";

                if($attribute->relation_type === 'belongsTo'){
                    $inFunction = $inFunction.",'$attribute->name'";
                }

                $function = "public function $attribute->function_name(){
                    return \$this->$attribute->relation_type($inFunction);
                } \n \n";

                $use = "use App\Models\generated\\$foreign->model; \n";

                if(self::searchForModel($foreign->model) !== false){
                    $use = "use App\Models\\$foreign->model; \n";
                }

                if($foreign->id === $subject->id){
                    $use = "//own model; \n";
                }

                $functions = $functions.$function;

                if(!in_array($use,$uses)){
                    array_push($uses,$use);
                };
            }
        }

        if(count($uses) > 0){
            $uses = implode('',$uses);
        } else {
            $uses = "//models used";
        }

        return array($uses,$functions);
    }

    public static function searchForModel($model){
        $finder = new ClassFinder();
        $classes = $finder->getClassesInFolder('app/Models');

        foreach($classes as $class){
            if($class === "App\Models\\$model"){
                return "App\Models\\$model";
            }
        }

        return false;
    }

    public static function getDefaults($subject){
        $defaults = "";
        foreach($subject->attributes as $attribute){

            if($attribute->type === 'relation' || $attribute->required == true){
                continue;
            } else {
                $value;
                $name = $attribute->name;

                //echo "$attribute \n \n";

                $default = false;

                if($attribute->default != null){
                    $default = $attribute->default;
                    echo "default $default \n";
                }

                switch($attribute->type){
                    case 'boolean':
                        $value = $default === false ? false : boolval($default);
                        break;
                    case 'integer':
                        $value = $default === false ? 0 : intval($default);
                        break;
                    case 'rememberToken':
                        continue 2;
                    case 'relation':
                        $value = $default === false ? 0 : $default;
                        break;
                    case 'date':
                        $value = $default === false ? now() : $default;
                        break;
                    default:
                        $value = $default === false ? "''" : $default;
                        break;
                }

                $defaults = $defaults."'$name' => $value, \n";
            }
        }
        return $defaults;
    }
}
