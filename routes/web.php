<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/admin', function () {
    return view('admin.dashboard');
});

Route::get('/admin/add-course', function () {
    return view('admin.add-course');
})->name('admin-add-course');

Route::get('/admin/edit-course/{course}', function ($course) {
    return view('admin.edit-course', ['course' => $course]);
})->name('admin-edit-course');


Route::get('/admin/courses', function () {
    return view('admin.courses');
})->name('admin-courses');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:admin',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
});

Route::get('/courses', function () {
    return view('courses.index');
})->name('courses');
Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');
Route::get('/courses/{courseId}/videos/{videoId}', function ($courseId, $videoId) {
    return view('courses.video', compact('courseId', 'videoId'));
})->name('video');
