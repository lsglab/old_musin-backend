<?php
namespace App\Console\Commands\Utils;

use App\Models\Subject;

class GenerateMigration {

    public static function run($subject){
        $attributes = GenerateMigration::attributeString($subject->attributes);
        $table = $subject->table;
        $className = GenerateMigration::generateClassName($subject->table);

        return "<?php

        use Illuminate\Database\Migrations\Migration;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Support\Facades\Schema;

        class $className extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create('$table', function (Blueprint \$table) {
                        \$table->id();
                    $attributes
                        \$table->timestamps();
                });
            }

            /**
             * Reverse the migrations.
             *
             * @return void
             */
            public function down()
            {
                Schema::dropIfExists('$table');
            }
        }";
    }

    public static function attributeString($attributes){
        $string = '';
        $unique = array();

        foreach($attributes as $attribute){

            $part = "\t\t\t\$table->";
            $name = $attribute->name;

            switch($attribute->type){
                case 'integer':
                    $part = $part."integer('$name')";
                    break;
                case 'boolean':
                    $part = $part."boolean('$name')";
                    break;
                case 'string':
                    $part = $part."string('$name')";
                    break;
                case 'date':
                    $part = $part."datetime('$name')";
                    break;
                case 'password':
                    $part = $part."string('$name')";
                    break;
                case 'email':
                    $part = $part."string('$name')";
                    break;
                case 'enum':
                    $part = $part."string('$name')";
                    break;
                case 'rememberToken':
                    $part = $part."rememberToken()";
                    break;
                case 'relation':

                    $foreign = Subject::where('id',$attribute->relation)->first();
                    $name = strtolower($foreign->model)."_id";

                    if($attribute->relation_type == 'belongs_to'){
                        if($attribute->name === $name){
                            $part = $part."foreignId('$name')";
                        } else {
                            $part = $part."integer('$attribute->name')";
                        }
                    } else {
                        continue 2;
                    }

                    break;
                default:
                    continue 2;
            }

            if($attribute->unique){
                $part = $part."->unique()";
            }

            if(!$attribute->required){
                $part = $part."->nullable()";
            }

            if($attribute->identifier == true){
                array_push($unique,"'$name'");
            }


            $part = $part.";\n";
            $string = $string.$part;
        }

        if(count($unique) > 0){
            $implode = implode(',',$unique);
            $string = $string."\$table->unique([$implode]);\n";
        }

        return $string;
    }

    public static function generateClassName($tableName){
        $parts = explode('_',$tableName);
        $string = 'Create';

        foreach($parts as $part){
            $part = ucwords($part);
            $string = $string.$part;
        }

        return $string.'Table';
    }
}
