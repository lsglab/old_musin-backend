<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Time implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private string $hoursRegex = "/^[0-2][0-9]$/";
    private string $minsecRegex = "/^[0-5][0-9]$/";

    public function __construct()
    {
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
        $split = explode(':',$value);

        if(count($split) !== 3) return false;

        $hours = $split[0];
        $minutes = $split[1];
        $seconds = $split[2];

        $hourMatch = preg_match($this->hoursRegex,$hours);
        $minuteMatch = preg_match($this->minsecRegex,$minutes);
        $secondMatch = preg_match($this->minsecRegex,$seconds);

        return ($hourMatch && $minuteMatch && $secondMatch);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Given time is invalid';
    }
}
