<?php

namespace App\Observers;

use App\Models\Subject;

class SubjectObserver
{

    public function creating(Subject $subject){
        $table = strtolower($subject->model);

        if(!str_ends_with($table,'s')){
            $table = $table.'s';
        }

        $subject->table = $table;

        return $subject;
    }

    /**
     * Handle the Subject "created" event.
     *
     * @param  \App\Models\Subject  $subject
     * @return void
     */
    public function created(Subject $subject)
    {
        //
    }

    /**
     * Handle the Subject "updated" event.
     *
     * @param  \App\Models\Subject  $subject
     * @return void
     */
    public function updated(Subject $subject)
    {
        //
    }

    /**
     * Handle the Subject "deleted" event.
     *
     * @param  \App\Models\Subject  $subject
     * @return void
     */
    public function deleted(Subject $subject)
    {
        //
    }

    /**
     * Handle the Subject "restored" event.
     *
     * @param  \App\Models\Subject  $subject
     * @return void
     */
    public function restored(Subject $subject)
    {
        //
    }

    /**
     * Handle the Subject "force deleted" event.
     *
     * @param  \App\Models\Subject  $subject
     * @return void
     */
    public function forceDeleted(Subject $subject)
    {
        //
    }
}
