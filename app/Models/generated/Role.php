<?php

namespace App\Models\generated;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; 
use App\Models\generated\Permission; 
use App\Models\generated\EntryPermission; 


class Role extends Model
{
    use HasFactory;

    protected $fillable = ['creator_id','name','description','admin',];
    protected $hidden = [];
    protected $attributes = ['description' => '', 
'admin' => false, 
];
    protected $casts = ['admin' => 'boolean',];

    //relationships: 

                
	public function created_by(){
        return $this->belongsTo(User::class,'creator_id');
    }
                
	public function permissions(){
        return $this->hasMany(Permission::class);
    }
                
	public function users(){
        return $this->hasMany(User::class);
    }
                
	public function entry_permissions_by_role(){
        return $this->hasMany(EntryPermission::class);
    }
                
	public function entry_permissions(){
        return $this->morphMany(EntryPermission::class,'entry');
    }
}