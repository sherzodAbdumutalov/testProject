<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles(){
        return $this->belongsToMany('App\Role', 'user_role');
    }

    public function canDo($permission, $require = false){

        if (is_array($permission)){
            foreach ($permission as $permName){
                $permName = $this->canDo($permName);
                if ($permName && !$require){
                    return true;
                }
                elseif (!$permName && $require){
                    return false;
                }
            }
            return $require;
        }
        else{
            foreach ($this->roles as $role){
                foreach ($role->permissions as $perm){
//                    if (str_is($permission, $perm->name)){}
                    if(str_is($permission,$perm->name)) {
                        return TRUE;
                    }
                }
            }
        }

    }


    public function hasRole($name, $require = false){

        if (is_array($name)){
            foreach ($name as $roleName){
                $hasRole = $this->hasRole($roleName);
                if ($hasRole && !$require){
                    return true;
                }
                elseif (!$hasRole && $require){
                    return false;
                }
            }
            return $require;
        }
        else{
            foreach ($this->roles as $role){
                foreach ($role->permissions as $perm){
                    if($perm->name == $name) {
                        return TRUE;
                    }
                }
            }
        }

    }
}
