<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Subject;
use App\Models\Permission;
use App\Models\Media;
use App\Models\Attribute;

class DatabaseSeeder extends Seeder{

    public function run(){
        $actions = array('read','edit','create','delete','edit-self','delete-self','read-self');
        $subjects = array();

        $admin = Role::factory()->create();
        $public = Role::factory()->create([
            'name' => 'Public',
            'description' => 'Diese Rolle steht für jeden nicht authentifizierten Benutzer',
            'admin' => false,
        ]);

        // $media = Subject::factory()->create([
        //     'displayName' => 'Media Library',
        //     'type' => 'media',
        //     'editable' => false,
        //     'model' => 'Media',
        //     'table' => 'media'
        // ]);

        $permissions = Subject::factory()->create([
            'displayName' => 'Permissions',
            'type' => 'auth',
            'model' => 'TestPermission',
            'table' => 'test_permissions',
            'editable' => false
        ]);

        $roles = Subject::factory() -> create([
            'displayName' => 'Rollen',
            'model' => 'TestRole',
            'editable' => false,
            'type' => 'auth',
            'table' => 'test_roles'
        ]);

        $users = Subject::factory() -> create([
            'displayName' => 'Benutzer',
            'type' => 'auth',
            'authenticatable' => true,
            'editable' => false,
            'model' => 'TestUser',
            'table' => 'test_users'
        ]);

        $content = Subject::factory() -> create([
            'displayName' => 'Content Manager',
            'type' => 'subject',
            'editable' => false,
            'model' => 'Subject',
            'table' => 'subjects'
        ]);

        array_push($subjects,$roles,$users,$content,$permissions);

        foreach($subjects as $subject){
            foreach($actions as $action){
                Permission::factory()->create([
                    'action'=>$action,
                    'role_id'=>$admin->id,
                    'subject_id'=>$subject->id
                ]);

                if($subject->path==='media'){
                    if($action === 'read'){
                        Permission::factory()->create([
                            'action'=>$action,
                            'role_id'=>$public->id,
                            'subject_id'=>$subject->id,
                        ]);
                    };
                }

                if($subject->path==='roles'){
                    if($action === 'read-self'){
                        Permission::factory()->create([
                            'action'=>$action,
                            'role_id'=>$public->id,
                            'subject_id'=>$subject->id
                        ]);
                    }
                }
            }
        }

        $user = User::factory()->create([
            'name'=> 'Simon Weckler',
            'email' => 'simon.weckler@mnet-online.de',
            'password' => Hash::make('isgMidv1.12'),
        ]);


        Attribute::factory()->create([
            'name' => 'name',
            'type' => 'string',
            'required' => true,
            'subject_id' => $users->id
        ]);

        Attribute::factory()->create([
            'name' => 'email',
            'type' => 'string',
            'required' => true,
            'unique' => true,
            'subject_id' => $users->id
        ]);

        Attribute::factory()->create([
            'name' => 'password',
            'type' => 'password',
            'required' => true,
            'subject_id' => $users->id
        ]);

        Attribute::factory()->create([
            'name' => 'role_id',
            'type' => 'relation',
            'required' => true,
            'relation' => $roles->id,
            'relation_type' => 'hasOne',
            'subject_id' => $users->id
        ]);

        Attribute::factory()->create([
            'name' => 'rememberToken',
            'type' => 'rememberToken',
            'subject_id' => $users->id,
            'required' => true,
        ]);

        Attribute::factory()->create([
            'name' => 'name',
            'type' => 'string',
            'required' => true,
            'subject_id' => $roles->id
        ]);

        Attribute::factory()->create([
            'name' => 'description',
            'type' => 'string',
            'subject_id' => $roles->id
        ]);

        Attribute::factory()->create([
            'name' => 'admin',
            'required' => true,
            'type' => 'boolean',
            'subject_id' => $roles->id
        ]);

        Attribute::factory()->create([
            'name' => 'permissions',
            'type' => 'relation',
            'relation' => $permissions->id,
            'relation_type' => 'hasMany',
            'subject_id' => $roles->id
        ]);

        Attribute::factory()->create([
            'name' => 'users',
            'type' => 'relation',
            'relation' => $users->id,
            'relation_type' => 'hasMany',
            'subject_id' => $roles->id
        ]);

        Attribute::factory()->create([
            'name' => 'action',
            'type' => 'string',
            'required' => true,
            'subject_id' => $permissions->id
        ]);

        Attribute::factory()->create([
            'name' => 'role_id',
            'type' => 'relation',
            'required' => true,
            'relation' => $roles->id,
            'relation_type' => 'belongsTo',
            'subject_id' => $permissions->id
        ]);

        Attribute::factory()->create([
            'name' => 'subject_id',
            'type' => 'relation',
            'required' => true,
            'relation' => $content->id,
            'relation_type' => 'belongsTo',
            'subject_id' => $permissions->id
        ]);
    }
}

