<?php
namespace App\Console\Commands\Utils;

use App\Models\Subject;
use Illuminate\Support\Str;

class GenerateModel {

    public static function run($subject){

        $fields = GenerateModel::getFields($subject);
        $fillable = $fields[0];
        $hidden = $fields[1];

        $relations = GenerateModel::getRelations($subject);
        $uses = $relations[0];
        $functions = $relations[1];

        $attributes = GenerateModel::getDefaults($subject);

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

            if($attribute->type === 'relation'){
                continue;
            }

            if($attribute->type === 'password' || $attribute->type === 'rememberToken'){
                $string = $string."'$attribute->name'".',';
                $hidden = $hidden.$string;
            } else {
                $string = $string."'$attribute->name'".',';
                $fillable = $fillable.$string;
            }
        }

        return array($fillable,$hidden);
    }

    public static function getRelations($subject){
        $functions = "//relationships: \n";
        $uses = "//models used: \n";

        foreach($subject->attributes as $attribute){
            if($attribute->type === 'relation'){
                $foreign = Subject::where('id',$attribute->relation)->first();

                $functionName = $foreign->table;

                $function = "public function $functionName(){
                    \$this->$attribute->relation_type($foreign->model::class);
                } \n \n";

                $use = "use App\Models\generated\\$foreign->model; \n";

                $functions = $functions.$function;
                $uses = $uses.$use;
            }
        }

        return array($uses,$functions);
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
