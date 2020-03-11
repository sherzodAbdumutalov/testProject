<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';
    protected $fillable = ['name'];

    public function roles(){
        return $this->belongsToMany('App\Role', 'role_permission');
    }

    public function changePermissions($request){
        if (Gate::denies('add_user', new User)){
            abort(403);
        }

        $data = $request->except('_token');
        $roles = Role::all();

        foreach ($roles as $role){

            if (isset($data[$role->id])){
                $role->savePermissions($data[$role->id]);
            }
            else{
                $role->savePermissions([]);
            }

        }
        return ['status'=>'malumot yangilandi'];

    }
}
