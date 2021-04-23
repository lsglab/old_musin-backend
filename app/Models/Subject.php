<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Permission;
use App\Models\Attribute;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'displayName',
        'editable',
        'authenticatable',
        'description',
        'model',
        'type',
        'table'
    ];

    // every subject has multiple permissions
    public function permission(){
        return $this->hasMany(Permission::class);
    }

    public function attributes(){
        return $this->hasMany(Attribute::class);
    }
}
