<?php

namespace App\Observers;

use App\Models\Subject;
use App\Models\Attribute;
include_once __DIR__.'/Helper/helper.php';

class SubjectObserver
{

    public function creating(Subject $subject){
        $table = toSnakeCase($subject->model);

        if(!str_ends_with($table,'s')){
            $table = $table.'s';
        }

        $subject->table = strtolower($table);

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
            'relation_type' => 'belongs_to',
            'relation' => $users->id,
            'subject_id' => $subject->id
        ]);

        Attribute::create([
            'name' => 'id',
            'type' => 'id',
            'subject_id' => $subject->id
        ]);

        Attribute::create([
            'name' => 'created_at',
            'type' => 'timestamp',
            'subject_id' => $subject->id
        ]);

        Attribute::create([
            'name' => 'updated_at',
            'type' => 'timestamp',
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
