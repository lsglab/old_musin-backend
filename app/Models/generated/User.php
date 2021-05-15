<?php

namespace App\Models\generated;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//own model; 
use App\Models\generated\Role; 
use App\Models\generated\EntryPermission; 

use Illuminate\Foundation\Auth\User as Authenticatable; 

            

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['creator_id','name','email','password','role_id',];
    protected $hidden = ['password','remember_token',];
    protected $attributes = [];
    protected $casts = [];

    //relationships: 

                
	public function created_by(){
        return $this->belongsTo(User::class,'creator_id');
    }
                
	public function role(){
        return $this->belongsTo(Role::class,'role_id');
    }
                
	public function entry_permissions(){
        return $this->morphMany(EntryPermission::class,'entry');
    }
}