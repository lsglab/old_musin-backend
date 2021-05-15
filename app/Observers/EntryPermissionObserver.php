<?php

namespace App\Observers;

use App\Models\generated\EntryPermission;
use App\Models\Subject;
use App\Console\Commands\Utils\ClassFinder;

class EntryPermissionObserver
{
    /**
     * Handle the EntryPermission "created" event.
     *
     * @param  \App\Models\EntryPermission  $entryPermission
     * @return void
     */
    public function creating(EntryPermission $entryPermission)
    {
        $subject = Subject::where('id',$entryPermission->subject_id)->first();

        $finder = new ClassFinder();
        $model = $finder->searchForModel($subject->model);

        $entryPermission->entry_type = $model;
        return $entryPermission;
    }

    /**
     * Handle the EntryPermission "updated" event.
     *
     * @param  \App\Models\EntryPermission  $entryPermission
     * @return void
     */
    public function updated(EntryPermission $entryPermission)
    {
        //
    }

    /**
     * Handle the EntryPermission "deleted" event.
     *
     * @param  \App\Models\EntryPermission  $entryPermission
     * @return void
     */
    public function deleted(EntryPermission $entryPermission)
    {
        //
    }

    /**
     * Handle the EntryPermission "restored" event.
     *
     * @param  \App\Models\EntryPermission  $entryPermission
     * @return void
     */
    public function restored(EntryPermission $entryPermission)
    {
        //
    }

    /**
     * Handle the EntryPermission "force deleted" event.
     *
     * @param  \App\Models\EntryPermission  $entryPermission
     * @return void
     */
    public function forceDeleted(EntryPermission $entryPermission)
    {
        //
    }
}
