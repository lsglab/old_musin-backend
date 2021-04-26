<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subject;

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
        'function_name',
        'unique',
        'id',
        'subject_id',
        'identifier',
    ];

    protected $attributes = [
        'function_name' => null,
        'required' => true,
        'default' => null,
        'unique' => false,
        'relation' => null,
        'relation_type' => null,
        'enum' => null,
        'identifier' => false,
    ];

    function subject(){
        return $this->belongsTo(Subject::class);
    }
}
