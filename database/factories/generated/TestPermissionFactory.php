
        <?php

        namespace Database\Factories;

        use App\Models\generated\TestPermission;
        use Illuminate\Database\Eloquent\Factories\Factory;

        class TestPermissionFactory extends Factory
        {
            /**
             * The name of the factory's corresponding model.
             *
             * @var string
             */
            protected $model = TestPermission::class;

            /**
             * Define the model's default state.
             *
             * @return array
             */
            public function definition(){
                return [
                    // values 
'action' => '', 

                ];
            }
        }