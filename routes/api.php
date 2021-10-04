<?php
use App\Models\Post;
use App\Models\Comment;
use App\Models\Category;
use App\Http\Controllers\PostApiController;
use App\Http\Controllers\CategoryApiController;
use App\Http\Controllers\CommentApiController;
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


Route::get('/categories', [CategoryApiController::class, 'index']);

Route::post('/categories', [CategoryApiController::class, 'store']);

Route::put('/categories/{category}', [CategoryApiController::class, 'update']);

Route::delete('/categories/{category}', [CategoryApiController::class, 'destroy']);

Route::get('/categories/{id}', [CategoryApiController::class, 'wanted']);



Route::get('/comments', [CommentApiController::class, 'index']);

Route::post('/comments', [CommentApiController::class, 'store']);

Route::put('/comments/{comment}', [CommentApiController::class, 'update']);

Route::delete('/comments/{comment}', [CommentApiController::class, 'destroy']);

Route::get('/comments/{id}', [CommentApiController::class, 'wanted']);
