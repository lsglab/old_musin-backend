<?php
namespace App\Console\Commands\Utils;

use App\Models\Subject;
use Illuminate\Support\Str;

class GenerateFactory {

    public static function run($subject){

        $blueprint = GenerateFactory::blueprint($subject);

        return "
        <?php

        namespace Database\Factories;

        use App\Models\generated\\$subject->model;
        use Illuminate\Database\Eloquent\Factories\Factory;

        class {$subject->model}Factory extends Factory
        {
            /**
             * The name of the factory's corresponding model.
             *
             * @var string
             */
            protected \$model = {$subject->model}::class;

            /**
             * Define the model's default state.
             *
             * @return array
             */
            public function definition(){
                return [
                    $blueprint
                ];
            }
        }";
    }

    public static function blueprint($subject){
        $blueprint = "// values \n";
        foreach($subject->attributes as $attribute){

            if($attribute->type === 'relation'){
                continue;
            } else {
                $value;
                $name = $attribute->name;

                $default = false;

                if($attribute->default != null){
                    $default = $attribute->default;
                }

                switch($attribute->type){
                    case 'boolean':
                        $value = !$default ? false : $default;
                    case 'integer':
                        $value = !$default ? 0 : $default;
                    case 'rememberToken':
                        $value = !$default ? Str::random(60) : $default;
                    case 'relation':
                        $value = !$default ? 0 : $default;
                    case 'date':
                        $value = !$default ? now() : $default;
                    default:
                        $value = !$default ? "''" : $default;
                }

                $blueprint = $blueprint."'$name' => $value, \n";
            }
        }
        return $blueprint;
    }
}
