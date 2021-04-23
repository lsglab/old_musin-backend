<?php

        namespace App\Models\generated;

        use Illuminate\Database\Eloquent\Factories\HasFactory;
        use Illuminate\Database\Eloquent\Model;
        //models used: 
use App\Models\generated\Permission; 
use App\Models\generated\Users; 


        class Role extends Model
        {
            use HasFactory;

            protected $fillable = ['name','description','admin',];
            protected $hidden = [];
            protected $attributes = ['description' => '', 
];

            //relationships: 
public function permissions(){
                    $this->hasMany(Permission::class);
                } 
 
public function users(){
                    $this->hasMany(Users::class);
                } 
 

        }