<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Observers\Base\MainObserver;
use App\Observers\UserObserver;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\File;
use App\Models\ColumnPermission;
use App\Models\Site;
use App\Models\Appointment;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Appointment::observe(MainObserver::class);
        User::observe(UserObserver::class);
        Role::observe(MainObserver::class);
        Permission::observe(MainObserver::class);
        File::observe(MainObserver::class);
        Site::observe(MainObserver::class);
        ColumnPermission::observe(MainObserver::class);
        //EntryPermission::observe(EntryPermissionObserver::class);
    }
}
