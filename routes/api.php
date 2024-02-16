<?php

use App\Http\Controllers\API\V1\Auth\AuthController;
use App\Http\Controllers\API\V1\Auth\ForgetPasswordController;
use App\Http\Controllers\API\V1\Auth\LocationController;
use App\Http\Controllers\API\V1\Auth\ResetPasswordController;
use App\Http\Controllers\API\V1\Comment\CommentController;
use App\Http\Controllers\API\V1\FriendShip\FriendController;
use App\Http\Controllers\API\V1\Post\LikePostController;
use App\Http\Controllers\API\V1\Post\PostsController;
use App\Http\Controllers\API\V1\Post\SharePostController;
use App\Http\Controllers\API\V1\Profile\ProfileController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::get('logout', [AuthController::class, 'logOut'])->middleware('auth:sanctum');

    Route::post('send-temp-password', [ForgetPasswordController::class, 'sendTempPassword']);
});


Route::prefix('profile')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [ProfileController::class, 'getProfile']);
    Route::post('/', [ProfileController::class, 'updateProfile']);
    Route::post('/update-password', [ProfileController::class, 'updatePassword']);
});

