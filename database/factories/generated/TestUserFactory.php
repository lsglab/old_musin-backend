
        <?php

        namespace Database\Factories;

        use App\Models\generated\TestUser;
        use Illuminate\Database\Eloquent\Factories\Factory;

        class TestUserFactory extends Factory
        {
            /**
             * The name of the factory's corresponding model.
             *
             * @var string
             */
            protected $model = TestUser::class;

            /**
             * Define the model's default state.
             *
             * @return array
             */
            public function definition(){
                return [
                    // values 
'name' => '', 
'email' => '', 
'password' => '', 
'rememberToken' => '', 

                ];
            }
        }