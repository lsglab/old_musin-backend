<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Permission;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'description',
        'admin'
    ];


    //relationship between Role and permission -> Role has many permissions
    // eloquent assumes the field in the permission table is role_id
    // if the foreign key is sth else it has to be passed as second parameter of the hasMany function
    public function permissions(){
        return $this->hasMany(Permission::class);
    }
}
