<?php

namespace App\Http\Controllers\Permissions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Создает новое разрешение (полномочие).
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createPermission(Request $request)
    {
        $name = $request->input('name');
        $permission = Permission::create(['name' => $name]);
        return response()->json($permission);
    }

    /**
     * Возвращает список всех разрешений.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPermissions()
    {
        $permissions = Permission::all();
        return response()->json($permissions);
    }

    /**
     * Возвращает разрешение (полномочие) по имени.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPermissionByName(Request $request)
    {
        $name = $request->input('name');
        $permission = Permission::where('name', $name)->first();
        return response()->json($permission);
    }
}
