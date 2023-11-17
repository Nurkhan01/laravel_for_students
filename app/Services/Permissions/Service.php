<?php

namespace App\Services\Permissions;

use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Service
{
    public function create($data)
    {
        if ($role = Role::create($data)) {
            if ($permission = Permission::create(['name' => $data['name'].'Permission'])) {
                if ($role->givePermissionTo($permission) && $permission->assignRole($role)) {
                    return $role;
                }
            }
        }
        return false;
    }

    public function update($role, $data)
    {
        if($role->update($data)){
            $role->fresh();
            return $role;
        }
        return false;
    }
    public function index(){
        $rolePermission = DB::table('role_has_permissions')->get();
        return $rolePermission;
    }
}
