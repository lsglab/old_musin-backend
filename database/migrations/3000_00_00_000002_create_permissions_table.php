<?php

        use Illuminate\Database\Migrations\Migration;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Support\Facades\Schema;

        class CreatePermissionsTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create('permissions', function (Blueprint $table) {
                    					$table->integer('creator_id');
					$table->id();
					$table->timestamps();
					$table->string('action');
					$table->foreignId('role_id');
					$table->string('table');$table->unique(['action','role_id','table']);

                });
            }

            /**
             * Reverse the migrations.
             *
             * @return void
             */
            public function down()
            {
                Schema::dropIfExists('permissions');
            }
        }
