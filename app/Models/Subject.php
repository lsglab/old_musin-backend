<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\generated\Permission;
use App\Models\Attribute;
use App\Observer\SubjectObserver;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'displayName',
        'editable',
        'authenticatable',
        'description',
        'model',
        'table',
        'type',
    ];

    protected $attributes = [
        'description' => '',
        'authenticatable' => false,
    ];

    function generateTableName(){
        $table = strtolower($subject->model);

        if(!str_ends_with($table,'s')){
            $table = $table.'s';
        }

        return $table;
    }

    // every subject has multiple permissions
    public function permission(){
        return $this->hasMany(Permission::class);
    }

    public function attributes(){
        return $this->hasMany(Attribute::class);
    }
}
