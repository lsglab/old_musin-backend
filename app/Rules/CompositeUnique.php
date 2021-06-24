<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class CompositeUnique implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private string $table;
    private array $columns;

    public function __construct($table,$columns,$entry = null)
    {
        $this->table = $table;
        $this->columns = $columns;
        $this->entry = $entry;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $fields = array();
        // iterates over the other parameters and build the conditions for all the required fields
        foreach( $this->columns as $column) {
            $fields[ $column ] = request()->get( $column );
        }

        // query the table with all the conditions
        $query = DB::table( $this->table )->select( DB::raw( 1 ) )->where( $fields );

        if($this->entry !== null){
            $query = $query->where('id','!=',$this->entry->id);
        }

        $result = $query->first();

        return empty( $result ); // edited here
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $count = count($this->columns);
        $fields = implode(',',$this->columns);

        return "The $count fields $fields together are not unique.";
    }
}
