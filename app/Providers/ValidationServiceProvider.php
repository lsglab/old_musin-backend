<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ValidationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        error_log("booting");
        $this->app['validator']->replacer('composite_unique', function ($attribute,$valaue,$parameters,$validator) {
            error_log("using function");
            echo "function";
             // remove first parameter and assume it is the table name
            $table = array_shift( $parameters );

            // start building the conditions
            $fields = [ $attribute => $value ];

            // iterates over the other parameters and build the conditions for all the required fields
            while ( $field = array_shift( $parameters ) ) {
                $fields[ $field ] = $this->get( $field );
            }

            // query the table with all the conditions
            $result = DB::table( $table )->select( DB::raw( 1 ) )->where( $fields )->first();

            return empty( $result ); // edited here
        }, 'This entry already exists. Make sure it is unique' );
    }
}
