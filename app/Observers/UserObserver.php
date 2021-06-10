<?php

namespace App\Observers;


use App\Models\User;
use App\Observers\Base\MainObserver;
use App\Http\Controllers\TableController;
use Illuminate\Support\Str;

class UserObserver extends MainObserver
{

    public function creating($user)
    {
        $user = parent::creating($user);
        $user->setRememberToken($token = Str::random(60));
    }


    public function updated($user)
    {
        //
    }

    public function deleted($user)
    {
        //
    }

    public function restored($user)
    {
        //
    }

    public function forceDeleted($user)
    {
        //
    }
}
