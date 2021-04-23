<?php

        namespace App\Models\generated;

        use Illuminate\Database\Eloquent\Factories\HasFactory;
        use Illuminate\Database\Eloquent\Model;
        //models used: 
use App\Models\generated\TestRole; 

            use Illuminate\Foundation\Auth\User as Authenticatable; 

            

        class TestUser extends Authenticatable
        {
            use HasFactory;

            protected $fillable = ['name','email',];
            protected $hidden = ['password','rememberToken',];

            //relationships: 
public function testrole(){
                    $this->hasOne(TestRole::class);
                } 
 

        }