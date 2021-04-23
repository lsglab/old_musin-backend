<?php
namespace App\Console\Commands\Utils;

use App\Models\Subject;

class GenerateMigration {

    public static function run($subject){
        $attributes = GenerateMigration::attributeString($subject->attributes);
        $table = $subject->table;
        $className = GenerateMigration::generateClassName($subject->table);

        return "
        <?php

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
                case 'rememberToken':
                    $part = $part."rememberToken()";
                    break;
                case 'relation':

                    $foreign = Subject::where('id',$attribute->relation)->first();
                    $name = strtolower($foreign->table)."_id";

                    switch($attribute->relation_type)
                    {
                        case 'hasOne':
                            $part = $part."foreignId('$name')->constrained()";
                            break;
                        case 'belongsTo':
                            $part = $part."foreignId('$name')->constrained()";
                            break;
                        default:
                            continue 3;
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

            $part = $part.";\n";
            $string = $string.$part;
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
