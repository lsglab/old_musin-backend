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
        'unique',
        'subject_id'
    ];

    protected $attributes = [
        'required' => true,
        'default' => null,
        'unique' => false,
        'relation' => null,
        'relation_type' => null,
        'enum' => null
    ];

    function subject(){
        return $this->belongsTo(Subject::class);
    }
}
