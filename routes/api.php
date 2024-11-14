<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Permissions\PermissionController;
use App\Http\Controllers\Permissions\RolesController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', function () {
    return ['message' => 'Hello World'];
});
Route::get('posts', function () {
    return ['posts' => [
        [
            'id' => 1,
            'title' => 'Programing',
            'description' => 'This post about programming',
            'body' => 'In 2023 we have a lot of good programming languages, the mos popular are: JavaScript, Php, Golang, Python', 'Java', 'C#', 'C++'
        ],
        [
            'id' => 2,
            'title' => 'University in Almaty',
            'description' => 'This post about universities that located In Almaty',
            'body' => 'If you want to join to universities, firstful you have to think about Almaty'
        ],
        [
            'id' => 3,
            'title' => 'Computers',
            'description' => 'This post about computers',
            'body' => 'Nowadays in companies use DeLL, Lenovo and etc. computers'
        ],

    ]];
})->middleware(['jwt.auth', 'ensureUserHasRole:Moderator']);

Route::prefix('category')->group(function () {
        Route::post('restore-Category', [\App\Http\Controllers\CategoriesController::class, 'restoreCategory']);
        Route::post('store-Category', [\App\Http\Controllers\CategoriesController::class, 'store']);
        Route::put('update-Category/{category}', [\App\Http\Controllers\CategoriesController::class, 'update']);
        Route::get('categories', [\App\Http\Controllers\CategoriesController::class, 'index'])->middleware(['jwt.auth','checkAdminRole']);
        Route::delete('delete-Category/{id}', [\App\Http\Controllers\CategoriesController::class, 'delete']);
        Route::get('products-by-Category/{id}', [\App\Http\Controllers\CategoriesController::class, 'productsByCategory']);
        Route::get('get-info', [\App\Http\Controllers\CategoriesController::class, 'getInfo']);
});

Route::prefix('post')->group(function () {
    Route::get('posts-controller', [PostsController::class, 'index']);
    Route::get('post/{id}', [PostsController::class, 'getPostById']);
    Route::get('post-all', [PostsController::class, 'getAll']);
    Route::delete('delete/{id}', [PostsController::class, 'deletePost']);
//    Route::middleware(['jwt.auth','checkAdminRole'])->group(function () {
        Route::post('post-create', [PostsController::class, 'create']);
        Route::put('post-update/{post}', [PostsController::class, 'update']);
        Route::post('post-store', [PostsController::class, 'store']);
//    });

//Second lesson laravel
    Route::get('post-by-title', [PostsController::class, 'getPostByTitle']);
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class ,'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class ,'me']);

});

Route::post('register', [RegisterController::class ,'register']);

// Create Role
Route::post('/roles', [RolesController::class, 'createRole'])->middleware(['jwt.auth']);

// Get Roles
Route::get('/roles', [RolesController::class, 'getRoles'])->middleware(['jwt.auth']);

// Find Role by Name
Route::get('/roles/{name}', [RolesController::class, 'getRolesByName'])->middleware(['jwt.auth']);

// Create Permission
Route::post('/permissions', [PermissionController::class, 'createPermission'])->middleware(['jwt.auth']);

// Get Permissions
Route::get('/permissions', [PermissionController::class, 'index'])->middleware(['jwt.auth']);

// Find Permission by Name
Route::get('/permissions/{name}', [PermissionController::class, 'findPermissionByName'])->middleware(['jwt.auth']);

