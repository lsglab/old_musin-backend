<?php
namespace App\Console\Commands\Utils;

use App\Models\Subject;

class GenerateModel {

    public static function run($subject){

        $fields = self::getFields($subject);
        $fillable = $fields[0];
        $hidden = $fields[1];
        $casts = $fields[2];

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
    protected \$casts = [$casts];

    $functions
}";
    }

    public static function getFields($subject){
        $fillable = "";
        $hidden = "";
        $casts = "";

        foreach($subject->attributes as $attribute){
            $string = "";

            if($attribute->relation_type === 'has_many' || $attribute->relation_type === 'polymorphic_has_many'){
                continue;
            }

            if($attribute->hidden == true){
                $string = "'$attribute->name'".',';
                $hidden = $hidden.$string;
            }

            if($attribute->type !== 'timestamp' && $attribute->type !== 'id'){
                $string = "'$attribute->name'".',';
                $fillable = $fillable.$string;
            }


            switch($attribute->type){
                case 'boolean':
                    $casts = $casts."'$attribute->name' => 'boolean',";
                    break;
                case 'date':
                case 'timestamp':
                    //$casts = $casts."'$attribute->name' => 'datetime:Y-m-d h:m',";
                    break;
            }
        }

        if($subject->authenticatable){
            $hidden = $hidden."'remember_token',";
        }

        return array($fillable,$hidden,$casts);
    }

    public static function getRelations($subject){
        $functions = "//relationships: \n";
        $uses = array();

        foreach($subject->attributes as $attribute){
            if($attribute->type === 'relation'){
                $foreign = Subject::where('id',$attribute->relation)->first();

                $inFunction = "";

                if($foreign !== null){
                    $inFunction = "$foreign->model::class";
                }

                $relation_function = '';

                switch($attribute->relation_type){
                    case 'belongs_to':
                        $inFunction = $inFunction.",'$attribute->name'";
                        $relation_function = 'belongsTo';
                        break;
                    case 'has_many':
                        $relation_function = 'hasMany';
                        break;
                    case 'polymorphic_belongs_to':
                        $type = array_values($subject->attributes->filter(function($value,$key) use ($attribute){
                            return explode('_type',$value->name)[0] === $attribute->function_name && $value->type === 'polymorphic_type';
                        })->all())[0];

                        $inFunction = "__FUNCTION__,'$type->name','$attribute->name'";
                        $relation_function = 'morphTo';
                        break;
                    case 'polymorphic_has_many':
                        $relation = $foreign->attributes->firstWhere('relation_type','polymorphic_belongs_to');

                        $inFunction = $inFunction.",'$relation->function_name'";
                        $relation_function = 'morphMany';
                        break;
                }

                $function = "
                \n\tpublic function $attribute->function_name(){
        return \$this->$relation_function($inFunction);
    }";

                if($foreign !== null){
                    $use = "use App\Models\generated\\$foreign->model; \n";

                    if(self::searchForModel($foreign->model) !== false){
                        $use = "use App\Models\\$foreign->model; \n";
                    }

                    if($foreign->id === $subject->id){
                        $use = "//own model; \n";
                    }
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
                }

                switch($attribute->type){
                    case 'boolean':
                        $value = $default === false ? "false" : $default;
                        break;
                    case 'integer':
                        $value = $default === false ? 0 : intval($default);
                        $value = "$value";
                        break;
                    case 'rememberToken':
                        continue 2;
                    case 'relation':
                        $value = $default === false ? 0 : $default;
                        $value = "$value";
                        break;
                    case 'date':
                        $value = $default === false ? now() : $default;
                        $value = "'$value'";
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
