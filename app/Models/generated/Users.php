<?php

        namespace App\Models\generated;

        use Illuminate\Database\Eloquent\Factories\HasFactory;
        use Illuminate\Database\Eloquent\Model;
        //models used: 
use App\Models\generated\Role; 

            use Illuminate\Foundation\Auth\User as Authenticatable; 

            

        class Users extends Authenticatable
        {
            use HasFactory;

            protected $fillable = ['name','email',];
            protected $hidden = ['password','rememberToken',];
            protected $attributes = ['rememberToken' => '', 
];

            //relationships: 
public function roles(){
                    $this->hasOne(Role::class);
                } 
 

        }