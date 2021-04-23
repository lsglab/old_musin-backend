<?php
namespace App\Console\Commands\Utils;

use App\Models\Subject;

class GenerateModel {

    public static function run($subject){

        $fields = GenerateModel::getFields($subject);
        $fillable = $fields[0];
        $hidden = $fields[1];

        $relations = GenerateModel::getRelations($subject);
        $uses = $relations[0];
        $functions = $relations[1];

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

                $functionName = strtolower($foreign->model);

                if($attribute->relation_type !== 'hasOne'){
                    $functionName = $functionName.'s';
                }

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
}
