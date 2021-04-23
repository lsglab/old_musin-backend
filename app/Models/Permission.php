<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Role;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_id',
        'role_id',
        'action'
    ];

    //One Permission belongs to one role
    public function role(){
        return $this->belongsTo(Role::class);
    }

    //One permission belongs to one subject
    public function subject(){
        return $this->belongsTo(Subject::class);
    }
}
