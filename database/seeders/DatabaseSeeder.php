<?php

/*namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;
use App\Models\Attribute;

//Seeder to create default subjects

class DatabaseSeeder extends Seeder{

    public function run(){
        $users = Subject::create([
            'name' => 'Benutzer',
            'type' => 'auth',
            'creator_id' => 1,
            'authenticatable' => true,
            'editable' => false,
            'model' => 'User',
        ]);

        $roles = Subject::create([
            'name' => 'Rollen',
            'model' => 'Role',
            'creator_id' => 1,
            'editable' => false,
            'type' => 'auth',
        ]);

        $content = Subject::create([
            'name' => 'Content Manager',
            'type' => 'content-manager',
            'editable' => false,
            'creator_id' => 1,
            'model' => 'Subject',
            'table' => 'content-manager'
        ]);

        $attributes = Subject::create([
            'name' => 'Attributes',
            'type' => 'content-manager',
            'parent_id' => $content->id,
            'creator_id' => 1,
            'editable' => false,
            'model' => 'Attribute',
            'table' => 'attributes'
        ]);

        $permissions = Subject::create([
            'name' => 'Permissions',
            'type' => 'auth',
            'creator_id' => 1,
            'parent_id' => $roles->id,
            'model' => 'Permission',
            'editable' => false
        ]);

        $entryPermissions = Subject::create([
            'name' => 'Entry Permissions',
            'type' => 'auth',
            'creator_id'=> 1,
            'parent_id' => $permissions->id,
            'model' => 'EntryPermission',
            'editable' => false
        ]);

        //Attributes for user

        Attribute::create([
            'name' => 'name',
            'is_display_name' => true,
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

        //Attributes of role

        Attribute::create([
            'name' => 'name',
            'type' => 'string',
            'is_display_name' => true,
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
            'required' => false,
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

        Attribute::create([
            'function_name' => 'entry_permissions_by_role',
            'name' => 'entry_permissions_by_role',
            'type' => 'relation',
            'identifier' => true,
            'relation' => $entryPermissions->id,
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

        // Attributes of EntryPermission

        Attribute::create([
            'name' => 'action',
            'type' => 'enum',
            'enum' => 'read,edit,delete',
            'identifier' => true,
            'subject_id' => $entryPermissions->id
        ]);

        Attribute::create([
            'name' => 'role_id',
            'type' => 'relation',
            'relation' => $roles->id,
            'relation_type' => 'belongs_to',
            'identifier' => true,
            'subject_id' => $entryPermissions->id
        ]);

        Attribute::create([
            'name' => 'subject_id',
            'type' => 'relation',
            'identifier' => true,
            'relation' => $content->id,
            'relation_type' => 'belongs_to',
            'subject_id' => $entryPermissions->id
        ]);

        Attribute::create([
            'name' => 'entry_id',
            'type' => 'relation',
            'identifier' => true,
            'relation' => 0,
            'relation_type' => 'polymorphic_belongs_to',
            'subject_id' => $entryPermissions->id
        ]);
        //Attributes for content
        /*Attribute::create([
            'name' => 'subject_id',
            'type' => 'string',
            'is_display_name' => true,
            'subject_id' => $content->id
        ]);

        Attribute::create([
            'name' => 'description',
            'type' => 'string',
            'required' => false,
            'subject_id' => $content->id
        ]);

        Attribute::create([
            'name' => 'type',
            'type' => 'enum',
            'enum' => 'auth,content-manager',
            'subject_id' => $content->id
        ]);

        Attribute::create([
            'name' => 'authenticatable',
            'type' => 'boolean',
            'subject_id' => $content->id
        ]);

        Attribute::create([
            'name' => 'parent_id',
            'type' => 'relation',
            ''
        ]);

        $subjects = Subject::all();

        foreach($subjects as $subject){
            Attribute::create([
                'name' => 'entry_permissions',
                'type' => 'relation',
                'relation' => $entryPermissions->id,
                'relation_type' => 'polymorphic_has_many',
                'subject_id' => $subject->id
            ]);
        }
    }
}*/
