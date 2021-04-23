
        <?php

        use Illuminate\Database\Migrations\Migration;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Support\Facades\Schema;

        class CreateTestUsersTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create('test_users', function (Blueprint $table) {
                        $table->id();
                    			$table->string('name');
			$table->string('email')->unique();
			$table->string('password');
			$table->foreignId('test_roles_id')->constrained();
			$table->rememberToken();

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
                Schema::dropIfExists('test_users');
            }
        }