<?php

        use Illuminate\Database\Migrations\Migration;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Support\Facades\Schema;

        class CreateEntryPermissionsTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create('entry_permissions', function (Blueprint $table) {
                    					$table->integer('creator_id');
					$table->id();
					$table->timestamps();
					$table->string('action');
					$table->foreignId('role_id');
					$table->foreignId('subject_id');
					$table->string('entry_type')->nullable();
					$table->integer('entry_id');$table->unique(['action','role_id','subject_id','entry_id']);

                });
            }

            /**
             * Reverse the migrations.
             *
             * @return void
             */
            public function down()
            {
                Schema::dropIfExists('entry_permissions');
            }
        }