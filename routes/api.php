<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\AgeGroupController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\VideoController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\LikeController;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::get('/user', function (Request $request) {
    return response()->json($request->user()->load('roles'));
})->middleware('auth:sanctum');

//Cursos
Route::middleware([
    'auth:sanctum'
])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/age-groups', [AgeGroupController::class, 'index']);
    Route::get('/courses', [CourseController::class, 'index']);
    Route::get('/courses/{course}', [CourseController::class, 'show']);
    Route::post('/courses/subscribe/{course}', [CourseController::class, 'subscribe']);
    Route::get('/courses/{courseId}/videos/{videoId}', [VideoController::class, 'show']);
});

//Videos
Route::middleware([
    'auth:sanctum'
])->group(function () {
    Route::get('/videos/{videoId}/comments', [CommentController::class, 'index']);
    Route::post('/videos/{videoId}/comments', [CommentController::class, 'store']);
    Route::get('/videos/{videoId}/likes', [LikeController::class, 'show']);
    Route::post('/videos/{videoId}/likes', [LikeController::class, 'store']);
});
