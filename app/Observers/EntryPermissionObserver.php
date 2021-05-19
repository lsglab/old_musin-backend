<?php

namespace App\Observers;


use App\Models\EntryPermission;
use App\Observers\Base\MainObserver;
use App\Http\Controllers\TableController;

class EntryPermissionObserver extends MainObserver
{

    public function creating($entryPermission)
    {
        $entryPermission = parent::creating($entryPermission);
        $controller = new TableController();
        $table = $controller->get($entryPermission->table);
        $entryPermission->entry_type = $table->model;
        return $entryPermission;
    }


    public function updated($entryPermission)
    {
        //
    }

    public function deleted($entryPermission)
    {
        //
    }

    public function restored($entryPermission)
    {
        //
    }

    public function forceDeleted($entryPermission)
    {
        //
    }
}
