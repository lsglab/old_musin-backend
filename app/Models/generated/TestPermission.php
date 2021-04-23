<?php

        namespace App\Models\generated;

        use Illuminate\Database\Eloquent\Factories\HasFactory;
        use Illuminate\Database\Eloquent\Model;
        //models used: 
use App\Models\generated\TestRole; 
use App\Models\generated\Subject; 


        class TestPermission extends Model
        {
            use HasFactory;

            protected $fillable = ['action',];
            protected $hidden = [];

            //relationships: 
public function testroles(){
                    $this->belongsTo(TestRole::class);
                } 
 
public function subjects(){
                    $this->belongsTo(Subject::class);
                } 
 

        }