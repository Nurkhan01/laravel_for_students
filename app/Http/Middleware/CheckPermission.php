<?php

namespace App\Http\Middleware;

use App\Services\Traits\HttpRequestTrait;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;
use Spatie\Permission\Models\Role;
use GuzzleHttp\Client;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $permission)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            throw new AuthorizationException('Invalid or missing token.', 401);
        }

        // Получение всех разрешений пользователя
        $permissions = $user->getAllPermissions()->pluck('name')->toArray();

        // Проверка разрешения
        if (in_array($permission, $permissions) || in_array('dont_stop', $permissions)) {
            return $next($request);
        }

        throw new AuthorizationException('You do not have the required permissions.', 403);
    }

    protected $routeMiddleware = [
        // ...
        'permission' => \App\Http\Middleware\CheckPermission::class,
    ];

}
