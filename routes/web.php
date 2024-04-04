<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/schedule', [App\Http\Controllers\MyScheduleController::class, 'index'])->name('schedule');
Route::get('/book', [App\Http\Controllers\BookMeetingController::class, 'index'])->name('book');
Route::get('/viewsched', [App\Http\Controllers\ViewScheduleController::class, 'index'])->name('viewsched');
Route::get('/request', [App\Http\Controllers\RequestController::class, 'index'])->name('request');
