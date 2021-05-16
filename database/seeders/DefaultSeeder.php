<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;

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
        $tables = ['roles','users','permissions'];

        $admin = new Role()->create([
            'name' => 'Admin',
            'description' => 'Die Admin Rolle hat alle Berechtigungen',
            'admin' => true,
            'creator_id' => 1,
        ]);

        $public = new Role()->create([
            'name' => 'Public',
            'description' => 'Diese Rolle steht für jeden nicht authentifizierten Benutzer',
            'admin' => false,
            'creator_id' => 1,
        ]);

        $user = new User()->create([
            'name'=> 'Simon Weckler',
            'email' => 'simon.weckler@mnet-online.de',
            'password' => Hash::make('isgMidv1.12'),
            'role_id' => $admin->id,
            'creator_id' => 1,
        ]);

        $user2 = new User()->create([
            'name' => 'Public',
            'email' => 'public@lsg.de',
            'password' => '',
            'role_id' => $admin->id,
            'creator_id' => $user->id
        ]);

        foreach($table as $table){
            foreach($actions as &$action){
                //if($subject->model != 'User' || $action != 'read'){
                    new Permission()->create([
                        'action'=>$action,
                        'role_id'=>$admin->id,
                        'table'=>$table,
                        'creator_id' => $user->id
                    ]);
                //}
            }
        }

        /*foreach($subjects as $subject){
            foreach($actions as &$action){
                if($action === 'read' || $action === 'edit' || $action === 'delete'){
                    echo "action $action";
                    $finder = new ClassFinder();
                    $path = $finder->searchForModel($subject->model);
                    foreach($path::get() as $entry){
                        EntryPermission::create([
                            'action' => $action,
                            'role_id' => $admin->id,
                            'subject_id' => $subject->id,
                            'creator_id' => $user->id,
                            'entry_id' => $entry->id
                        ]);
                    }
                }
            }
        }*/

    }
}
