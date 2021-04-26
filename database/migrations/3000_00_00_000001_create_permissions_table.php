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
                        $table->id();
                    			$table->integer('creator_id');
			$table->string('action');
			$table->foreignId('role_id');
			$table->foreignId('subject_id');
$table->unique(['action','role_id','subject_id']);

                        $table->timestamps();
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