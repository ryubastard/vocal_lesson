<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\MyPageController;


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

Route::get('/register', function () {
    abort(404);
});

Route::get('/', function () {
    return view('calendar');
});

Route::prefix('manager')
    ->middleware('can:manager-higher')->group(function () {
        Route::get('lessons/past', [LessonController::class, 'past'])->name('lessons.past');
        Route::post('lessons/{lesson}/{id}/', [LessonController::class, 'cancel'])->name('lessons.cancel');
        Route::resource('lessons', LessonController::class);
        Route::get('lessons/{lesson}/{date}', [LessonController::class, 'overview'])->name('lessons.overview');
    });

Route::middleware('can:user-higher')->group(function () {
    Route::get('/dashboard',  [ReservationController::class, 'dashboard'])->name('dashboard');
    Route::get('/mypage',  [MyPageController::class, 'index'])->name('mypage.index');
    Route::get('/mypage/{id}',  [MyPageController::class, 'show'])->name('mypage.show');
    Route::post('/mypage/{id}', [MyPageController::class, 'cancel'])->name('mypage.cancel');
    Route::post('/{id}',  [ReservationController::class, 'reserve'])->name('lessons.reserve');
});

Route::get('/{id}',  [ReservationController::class, 'detail'])->name('lessons.detail');
Route::post('/confirmation/{id}',  [ReservationController::class, 'confirmation'])->name('lessons.confirmation');
Route::get('/store/{id}',  [ReservationController::class, 'create'])->name('registration.create');
Route::post('/register/confirmation/{id}', [ReservationController::class, 'verify'])->name('register.verification');
Route::post('/store/{id}',  [ReservationController::class, 'store'])->name('registration.store');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
