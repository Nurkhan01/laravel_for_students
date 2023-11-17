<?php

namespace App\Http\Controllers\Permissions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    /**
     * Создает новую роль.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createRole(Request $request)
    {
        $name = $request->input('name');
        $role = Role::create(['name' => $name]);
        return response()->json($role);
    }

    /**
     * Возвращает список всех ролей.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRoles()
    {
        $roles = Role::all();
        return response()->json($roles);
    }

    /**
     * Возвращает роль по имени.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRolesByName(Request $request)
    {
        $name = $request->input('name');
        $role = Role::where('name', $name)->first();
        return response()->json($role);
    }
}
