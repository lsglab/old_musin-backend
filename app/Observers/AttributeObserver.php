<?php

namespace App\Observers;

use App\Models\Attribute;
use App\Models\Subject;
include_once __DIR__.'/Helper/helper.php';

class AttributeObserver
{

    public function creating(Attribute $attribute){
        // echo "attribute: $attribute; \n";
        $attribute->name = toSnakeCase($attribute->name);
        $attribute->relation_type = toSnakeCase($attribute->relation_type);
        $attribute->function_name = toSnakeCase($attribute->function_name);

        if($attribute->function_name === null && $attribute->relation !== null){
            $foreign = Subject::where('id',$attribute->relation)->first();

            if($attribute->relation_type === 'belongs_to'){
                $attribute->function_name = strtolower($foreign->model);
            }
            else if($attribute->relation_type === 'polymorphic_belongs_to'){
                $attribute->function_name = explode('_id',$attribute->name)[0];

                Attribute::create([
                    'name' => "{$attribute->function_name}_type",
                    'hidden' => true,
                    'required' => false,
                    'type' => 'polymorphic_type',
                    'subject_id' => $attribute->subject_id
                ]);
            } else {
                $attribute->function_name = $foreign->table;
            }
        }

        if($attribute->type === 'password'){
            $attribute->hidden = true;
        }

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
