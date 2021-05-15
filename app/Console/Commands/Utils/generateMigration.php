<?php
namespace App\Console\Commands\Utils;

use App\Models\Subject;

class GenerateMigration {

    public static function run($subject){
        $attributes = GenerateMigration::attributeString($subject);
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
                    $attributes
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

    public static function attributeString($subject){
        $string = '';
        $unique = array();

        $parts = array();

        foreach($subject->attributes as $attribute){

            $part = "\t\t\t\t\t\$table->";
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
                case 'id':
                    $part = $part."id()";
                    break;
                case 'relation':
                    if($attribute->relation_type === 'polymorphic_belongs_to'){
                        $part = $part."integer('$attribute->name')";
                        break;
                    }

                    if($attribute->relation_type === 'belongs_to'){
                        $foreign = Subject::where('id',$attribute->relation)->first();
                        $name = strtolower($foreign->model)."_id";

                        if($attribute->name === $name){
                            $part = $part."foreignId('$name')";
                        } else {
                            $part = $part."integer('$attribute->name')";
                        }
                        break;
                    }

                    continue 2;
                case 'timestamp':
                    if(!in_array($part."timestamps();",$parts)){
                        $part = $part."timestamps()";
                        break;
                    }
                    continue 2;
                case 'polymorphic_type':
                    $part = $part."string('$name')";
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


            $part = $part.";";
            array_push($parts,$part);
        }

        $string = implode("\n",$parts);

        if(count($unique) > 0){
            $implode = implode(',',$unique);
            $string = $string."\$table->unique([$implode]);\n";
        }

        if($subject->authenticatable){
            $string = $string."\n\$table->rememberToken();";
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
