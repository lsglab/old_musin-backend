<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\generated\Role;
use App\Models\generated\Permission;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Subject;

//This Seeder is used for default data like the admin user and role;

class DefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $actions = array('read','edit','create','delete','edit-self','delete-self','read-self');
        $subjects = Subject::all()->all();

        $admin = Role::create([
            'name' => 'Admin',
            'description' => 'Die Admin Rolle hat alle Berechtigungen',
            'admin' => true,
        ]);

        $public = Role::create([
            'name' => 'Public',
            'description' => 'Diese Rolle steht für jeden nicht authentifizierten Benutzer',
            'admin' => false,
        ]);

        foreach($subjects as $subject){
            foreach($actions as $action){
                Permission::create([
                    'action'=>$action,
                    'role_id'=>$admin->id,
                    'subject_id'=>$subject->id
                ]);

                if($subject->path==='media'){
                    if($action === 'read'){
                        Permission::create([
                            'action'=>$action,
                            'role_id'=>$public->id,
                            'subject_id'=>$subject->id,
                        ]);
                    };
                }

                if($subject->path==='roles'){
                    if($action === 'read-self'){
                        Permission::create([
                            'action'=>$action,
                            'role_id'=>$public->id,
                            'subject_id'=>$subject->id
                        ]);
                    }
                }
            }
        }

        $user = User::create([
            'name'=> 'Simon Weckler',
            'email' => 'simon.weckler@mnet-online.de',
            'password' => Hash::make('isgMidv1.12'),
            'role_id' => $admin->id
        ]);

    }
}
