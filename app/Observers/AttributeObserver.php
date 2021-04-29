<?php

namespace App\Observers;

use App\Models\Attribute;
use App\Models\Subject;
include_once __DIR__.'/Helper/helper.php';

class AttributeObserver
{

    public function creating(Attribute $attribute){
        if($attribute->function_name == null && $attribute->relation != null){
            $foreign = Subject::where('id',$attribute->relation)->first();

            $attribute->function_name = $foreign->table;
        }

        $attribute->name = toSnakeCase($attribute->name);
        $attribute->relation_type = toSnakeCase($attribute->relation_type);
        $attribute->function_name = toSnakeCase($attribute->function_name);

        return $attribute;
    }
    /**
     * Handle the Attribute "created" event.
     *
     * @param  \App\Models\Attribute  $attribute
     * @return void
     */
    public function created(Attribute $attribute)
    {
        //
    }

    /**
     * Handle the Attribute "updated" event.
     *
     * @param  \App\Models\Attribute  $attribute
     * @return void
     */
    public function updated(Attribute $attribute)
    {
        //
    }

    /**
     * Handle the Attribute "deleted" event.
     *
     * @param  \App\Models\Attribute  $attribute
     * @return void
     */
    public function deleted(Attribute $attribute)
    {
        //
    }

    /**
     * Handle the Attribute "restored" event.
     *
     * @param  \App\Models\Attribute  $attribute
     * @return void
     */
    public function restored(Attribute $attribute)
    {
        //
    }

    /**
     * Handle the Attribute "force deleted" event.
     *
     * @param  \App\Models\Attribute  $attribute
     * @return void
     */
    public function forceDeleted(Attribute $attribute)
    {
        //
    }
}
