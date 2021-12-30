<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use App\Models\Site;
use App\Models\Component;
use App\Http\Controllers\Frontend\SiteController;

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
            'role_id' => $public->id,
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

        $nav = Component::create([
            'slot' => false,
            'description' => 'Die Navigationsleiste',
            'name' => 'Navbar',
            'blueprint' => json_encode([
                'componentName' => 'Empty',
                'id' => 'nav',
                'props'=> (object) null,
                'slot'=> true,
                'blueprint' => (object) null,
                'children' => [],
                'childrenTypes' => [],
            ]),
        ]);

        $footer = Component::create([
            'slot' => false,
            'description' => 'Der Footer',
            'name' => 'Footer',
            'blueprint' => json_encode([
                'componentName' => 'Empty',
                'id' => 'footer',
                'props' => (object) null,
                'slot' => true,
                'blueprint' => (object) null,
                'children' => [],
                'childrenTypes' => [],
            ]),
        ]);

        SiteController::seed();
    }
}
