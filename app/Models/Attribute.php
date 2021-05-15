<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subject;
use App\Models\User;
use App\Models\generated\EntryPermission;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'required',
        'default',
        'relation',
        'relation_type',
        'enum',
        'is_display_name',
        'creator_id',
        'function_name',
        'unique',
        'id',
        'subject_id',
        'hidden',
        'identifier',
    ];

    protected $attributes = [
        'function_name' => null,
        'required' => true,
        'default' => null,
        'unique' => false,
        'is_display_name' => false,
        'hidden' => false,
        'relation' => null,
        'relation_type' => null,
        'enum' => null,
        'identifier' => false,
        'creator_id' => 1
    ];

    protected $casts = [
        'required' => 'boolean',
        'unique' => 'boolean',
        'hidden' => 'boolean',
        'identifier' => 'boolean',
        'is_display_name' => 'boolean'
    ];

    function subject(){
        return $this->belongsTo(Subject::class);
    }

    function created_by(){
        return $this->belongsTo(User::class,'creator_by');
    }

    public function entry_permissions(){
        return $this->morphMany(EntryPermission::class,'entry');
    }
}
