<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\UserController;
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

// a protected group of route
Route::middleware(['auth:sanctum'])->group(function(){
    /* Route::apiResource('users', UserController::class);
    Route::apiResource('posts', PostsController::class);
    Route::apiResource('comments', CommentController::class); */
});

Route::apiResource('users', UserController::class);
Route::apiResource('posts', PostsController::class);
Route::apiResource('comments', CommentController::class);