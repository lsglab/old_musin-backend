<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;

//This Seeder is used for default data like the admin user and role;

class DatabaseSeeder extends Seeder
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
        $tables = ['roles','users','permissions','files','column_permissions','sites','appointments','components'];

        $admin = Role::create([
            'name' => 'Admin',
            'description' => 'Die Admin Rolle hat alle Berechtigungen',
        ]);

        $public = Role::create([
            'name' => 'Public',
            'description' => 'Diese Rolle steht für jeden nicht authentifizierten Benutzer',
        ]);

        $user = User::create([
            'name'=> 'Simon Weckler',
            'email' => 'simon.weckler@mnet-online.de',
            'password' => 'isgMidv1.12',
            'role_id' => $admin->id,
        ]);

        $user2 = User::create([
            'name' => 'Public',
            'email' => 'public@lsg.de',
            'password' => '',
            'role_id' => $admin->id,
        ]);

        foreach($tables as $table){
            foreach($actions as &$action){
                Permission::create([
                    'action'=>$action,
                    'role_id'=>$admin->id,
                    'table'=>$table,
                    'creator_id' => $user->id
                ]);
            }
        }
    }
}
