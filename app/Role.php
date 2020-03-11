<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $fillable = ['name'];

    public function users(){
        return $this->belongsToMany('App\User', 'user_role');
    }


    public function permissions(){
        return $this->belongsToMany('App\Permission', 'role_permission');
    }

    public function hasPermission($name, $require = false)
    {
        if (is_array($name)) {
            foreach ($name as $permissionName) {
                $hasPermission = $this->hasPermission($permissionName);

                if ($hasPermission && !$require) {
                    return true;
                } elseif (!$hasPermission && $require) {
                    return false;
                }
            }
            return $require;
        } else {
            foreach ($this->permissions as $permission) {
                if ($permission->name == $name) {
                    return true;
                }
            }
        }

        return false;
    }

    public function savePermissions($inputPerm){

        if (!empty($inputPerm)){
            $this->permissions()->sync($inputPerm);
        }
        else{
            $this->permissions()->detach();
        }

        return true;
    }
}
