<?php

namespace App\Observers;

use App\Models\Subject;
use App\Models\Attribute;

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
        $users = Subject::where("model","User")->first();

        Attribute::create([
            'name' => 'creator_id',
            'type' => 'relation',
            'function_name' => 'created_by',
            'relation_type' => 'belongsTo',
            'relation' => $users->id,
            'subject_id' => $subject->id
        ]);
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
