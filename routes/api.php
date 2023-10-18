<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminOnly;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix("v1")->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post("login", "login")->name("auth.login");
    });
    Route::middleware("auth:sanctum")->group(function(){
        Route::controller(AuthController::class)->group(function () {
            Route::get("devices", "devices")->name("auth.devices");
            Route::post("logout", 'logout')->name("auth.logout");
            Route::post("logout-all", 'logoutAll')->name("auth.logoutAll");
        });
        Route::apiResource('category', CategoryController::class);
        Route::apiResource('blog',BlogController::class);

        Route::prefix("user")->middleware(AdminOnly::class)->controller(UserController::class)->group(function () {
            Route::get("/", "list")->name("user.list");
            Route::get("banned-users", "bannedUsers")->name("user.bannedList");
            Route::post("register", "create")->name("user.register");
            Route::put("position-management/{id}", "updatePosition")->name("user.updatePosition");
            Route::put("ban/{id}", "ban")->name("user.ban");
            Route::put("unban/{id}", "unban")->name("user.unban");
        });
    });

});


