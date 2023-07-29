<?php

use App\Http\Controllers\ForumController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return 'HELLO WORLD';
// });



Route::get('/ideas', [ForumController::class, 'index']);
Route::get('/ideas/{id}', [ForumController::class, 'show']);
