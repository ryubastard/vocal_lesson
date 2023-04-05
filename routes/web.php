<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LessonController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('manager')
    ->middleware('can:manager-higher')->group(function () {
        Route::get('lessons/past', [lessonController::class, 'past'])->name('lessons.past');
        Route::post('lessons/{lesson}/{id}/', [lessonController::class, 'cancel'])->name('lessons.cancel');
        Route::resource('lessons', lessonController::class);
        Route::get('lessons/{lesson}/{date}', [lessonController::class, 'detail'])->name('lessons.detail');
    });

Route::middleware('can:user-higher')->group(function () {
    Route::get('index', function () {
        dd('user');
    });
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
