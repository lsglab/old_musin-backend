<?php

        namespace App\Models\generated;

        use Illuminate\Database\Eloquent\Factories\HasFactory;
        use Illuminate\Database\Eloquent\Model;
        //own model; 
use App\Models\generated\Role; 

            use Illuminate\Foundation\Auth\User as Authenticatable; 

            

        class User extends Authenticatable
        {
            use HasFactory;

            protected $fillable = ['creator_id','name','email','password','password','role_id',];
            protected $hidden = ['password','rememberToken',];
            protected $attributes = [];

            //relationships: 
public function created_by(){
                    return $this->belongsTo(User::class,'creator_id');
                } 
 
public function roles(){
                    return $this->belongsTo(Role::class,'role_id');
                } 
 

        }