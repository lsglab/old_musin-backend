<?php

        use Illuminate\Database\Migrations\Migration;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Support\Facades\Schema;

        class CreateUsersTable extends Migration
        {
            $columns = [];
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create('users', function (Blueprint $table) {
                    /*$table->integer('creator_id');
					$table->id();
                    $table->boolean('asdfd');
					$table->timestamps();
					$table->string('name');
					$table->string('email')->unique();
					$table->string('password');
					$table->foreignId('role_id');
                    $table->rememberToken();*/
                    foreach($columns as $column){
                        $column->createDBColumn($table);
                    }
                });
            }

            /**
             * Reverse the migrations.
             *
             * @return void
             */
            public function down()
            {
                Schema::dropIfExists('users');
            }
        }
