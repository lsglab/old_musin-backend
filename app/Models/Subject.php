<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\generated\Permission;
use App\Models\Attribute;
use App\Observer\SubjectObserver;
use App\Models\generated\EntryPermission;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'editable',
        'authenticatable',
        'description',
        'parent_id',
        'model',
        'table',
        'type',
    ];

    protected $attributes = [
        'description' => '',
        'authenticatable' => false,
    ];

    protected $casts = [
        'editable' => 'boolean',
        'authenticatable' => 'boolean'
    ];
    // every subject has multiple permissions
    public function permissions(){
        return $this->hasMany(Permission::class);
    }

    public function attributes(){
        return $this->hasMany(Attribute::class);
    }

    public function children(){
        return $this->hasMany(Subject::class,'parent_id','id');
    }

    public function createdBy(){
        return $this->belongsTo(User::class,'creator_id');
    }

    public function entry_permissions(){
        return $this->morphMany(EntryPermission::class,'entry');
    }
}
