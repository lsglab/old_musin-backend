<?php

        namespace App\Models\generated;

        use Illuminate\Database\Eloquent\Factories\HasFactory;
        use Illuminate\Database\Eloquent\Model;
        //models used: 
use App\Models\generated\TestPermission; 
use App\Models\generated\TestUser; 


        class TestRole extends Model
        {
            use HasFactory;

            protected $fillable = ['name','description','admin',];
            protected $hidden = [];

            //relationships: 
public function testpermissions(){
                    $this->hasMany(TestPermission::class);
                } 
 
public function testusers(){
                    $this->hasMany(TestUser::class);
                } 
 

        }