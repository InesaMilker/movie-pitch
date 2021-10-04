<?php
use App\Models\Post;
use App\Http\Controllers\PostApiController;
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

Route::get('/posts', [PostApiController::class, 'index']);

Route::post('/posts', [PostApiController::class, 'store']);

Route::put('/posts/{post}', [PostApiController::class, 'update']);

Route::delete('/posts/{post}', [PostApiController::class, 'destroy']);

Route::get('/posts/{id}', [PostApiController::class, 'wanted']);


Route::get('/categories', [PostApiController::class, 'index']);

Route::post('/categories', [PostApiController::class, 'store']);

Route::put('/categories/{category}', [PostApiController::class, 'update']);

Route::delete('/categories/{category}', [PostApiController::class, 'destroy']);

Route::get('/categories/{id}', [PostApiController::class, 'wanted']);



Route::get('/comments', [PostApiController::class, 'index']);

Route::post('/comments', [PostApiController::class, 'store']);

Route::put('/comments/{comment}', [PostApiController::class, 'update']);

Route::delete('/comments/{comment}', [PostApiController::class, 'destroy']);

Route::get('/comments/{id}', [PostApiController::class, 'wanted']);
