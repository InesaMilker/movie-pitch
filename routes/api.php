<?php
use App\Models\Post;
use App\Models\Comment;
use App\Models\Category;
use App\Http\Controllers\PostApiController;
use App\Http\Controllers\CategoryApiController;
use App\Http\Controllers\CommentApiController;
use App\Http\Controllers\AuthController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/me', [AuthController::class, 'me']);
});

Route::get('/posts', [PostApiController::class, 'index']);

Route::post('/posts', [PostApiController::class, 'store']);

Route::put('/posts/{id}', [PostApiController::class, 'update']);

Route::delete('/posts/{id}', [PostApiController::class, 'destroy']);

Route::get('/posts/{id}', [PostApiController::class, 'wanted']);

Route::get('/posts/{post}/comments', [PostApiController::class, 'wantedPost']);


Route::get('/categories', [CategoryApiController::class, 'index']);

Route::post('/categories', [CategoryApiController::class, 'store']);

Route::put('/categories/{id}', [CategoryApiController::class, 'update']);

Route::delete('/categories/{id}', [CategoryApiController::class, 'destroy']);

Route::get('/categories/{id}/posts', [CategoryApiController::class, 'wanted_post']);

Route::get('/categories/{id}', [CategoryApiController::class, 'wanted']);



Route::get('/comments', [CommentApiController::class, 'index']);

Route::post('/comments', [CommentApiController::class, 'store']);

Route::put('/comments/{comment}', [CommentApiController::class, 'update']);

Route::delete('/comments/{id}', [CommentApiController::class, 'destroy']);

Route::get('/comments/{id}', [CommentApiController::class, 'wanted']);
