<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;
use App\Models\Attribute;

//Seeder to create default subjects

class DatabaseSeeder extends Seeder{

    public function run(){
        $users = Subject::create([
            'displayName' => 'Benutzer',
            'type' => 'auth',
            'creator_id' => 1,
            'authenticatable' => true,
            'editable' => false,
            'model' => 'User',
        ]);

        $roles = Subject::create([
            'displayName' => 'Rollen',
            'model' => 'Role',
            'creator_id' => 1,
            'editable' => false,
            'type' => 'auth',
        ]);

        $permissions = Subject::create([
            'displayName' => 'Permissions',
            'type' => 'auth',
            'creator_id' => 1,
            'parent_id' => $roles->id,
            'model' => 'Permission',
            'editable' => false
        ]);

        $content = Subject::create([
            'displayName' => 'Content Manager',
            'type' => 'content-manager',
            'editable' => false,
            'creator_id' => 1,
            'model' => 'Subject',
            'table' => 'content-manager'
        ]);

        $attributes = Subject::create([
            'displayName' => 'Attributes',
            'type' => 'content-manager',
            'parent_id' => $content->id,
            'creator_id' => 1,
            'editable' => false,
            'model' => 'Attribute',
            'table' => 'attributes'
        ]);

        //Attributes for user

        Attribute::create([
            'name' => 'name',
            'type' => 'string',
            'subject_id' => $users->id
        ]);

        Attribute::create([
            'name' => 'email',
            'type' => 'email',
            'unique' => true,
            'subject_id' => $users->id
        ]);

        Attribute::create([
            'name' => 'password',
            'type' => 'password',
            'subject_id' => $users->id
        ]);

        Attribute::create([
            'name' => 'role_id',
            'type' => 'relation',
            'relation' => $roles->id,
            'relation_type' => 'belongs_to',
            'subject_id' => $users->id
        ]);

        Attribute::create([
            'name' => 'rememberToken',
            'type' => 'rememberToken',
            'subject_id' => $users->id,
            'required' => false,
        ]);

        //Attributes of role

        Attribute::create([
            'name' => 'name',
            'type' => 'string',
            'subject_id' => $roles->id
        ]);

        Attribute::create([
            'name' => 'description',
            'required' => false,
            'type' => 'string',
            'subject_id' => $roles->id
        ]);

        Attribute::create([
            'name' => 'admin',
            'default' => "false",
            'type' => 'boolean',
            'subject_id' => $roles->id
        ]);

        Attribute::create([
            'name' => 'permissions',
            'type' => 'relation',
            'relation' => $permissions->id,
            'relation_type' => 'has_many',
            'subject_id' => $roles->id
        ]);

        Attribute::create([
            'name' => 'role_id',
            'type' => 'relation',
            'relation' => $users->id,
            'relation_type' => 'has_many',
            'subject_id' => $roles->id
        ]);

        //Attributes of permission

        Attribute::create([
            'name' => 'action',
            'type' => 'enum',
            'enum' => 'read,read-self,edit,edit-self,delete,delete-self,create',
            'identifier' => true,
            'subject_id' => $permissions->id
        ]);

        Attribute::create([
            'name' => 'role_id',
            'type' => 'relation',
            'relation' => $roles->id,
            'relation_type' => 'belongs_to',
            'identifier' => true,
            'subject_id' => $permissions->id
        ]);

        Attribute::create([
            'name' => 'subject_id',
            'type' => 'relation',
            'identifier' => true,
            'relation' => $content->id,
            'relation_type' => 'belongs_to',
            'subject_id' => $permissions->id
        ]);
    }
}

