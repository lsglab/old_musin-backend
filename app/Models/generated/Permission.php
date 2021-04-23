<?php

        namespace App\Models\generated;

        use Illuminate\Database\Eloquent\Factories\HasFactory;
        use Illuminate\Database\Eloquent\Model;
        //models used: 
use App\Models\generated\Role; 
use App\Models\generated\Subject; 


        class Permission extends Model
        {
            use HasFactory;

            protected $fillable = ['action',];
            protected $hidden = [];
            protected $attributes = [];

            //relationships: 
public function roles(){
                    $this->belongsTo(Role::class);
                } 
 
public function subjects(){
                    $this->belongsTo(Subject::class);
                } 
 

        }