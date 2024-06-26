<?php

use App\Http\Livewire\AccountSettings;
use App\Http\Livewire\BookMeeting;
use App\Http\Livewire\RefDepartments;
use App\Http\Livewire\RefSignatories;
use App\Http\Livewire\Request;
use App\Http\Livewire\Schedule;
use App\Http\Livewire\UserManagement;
use App\Http\Livewire\ViewSchedule;
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

// Disable registration
Auth::routes(['register' => false]);

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware'  =>  ['auth', 'check.default.password']], function () {

    # Old routes
    //// Route::get('/schedule', [App\Http\Controllers\MyScheduleController::class, 'index'])->name('schedule');
    //// Route::get('/book', [App\Http\Controllers\BookMeetingController::class, 'index'])->name('book');
    //// Route::get('/viewsched', [App\Http\Controllers\ViewScheduleController::class, 'index'])->name('viewsched');
    //// Route::get('/request', [App\Http\Controllers\RequestController::class, 'index'])->name('request');

    Route::get('/schedule', Schedule::class)->name('schedule');
    Route::get('/book', BookMeeting::class)->name('book');
    Route::get('/viewsched', ViewSchedule::class)->name('viewsched');
});

Route::group(['middleware' => ['auth', 'superadmin', 'check.default.password']], function () {
    Route::get('/request', Request::class)->name('request');
    Route::get('/user-management', UserManagement::class)->name('user-management');
    Route::get('/ref/departments', RefDepartments::class)->name('ref-departments');
    Route::get('/ref/signatories', RefSignatories::class)->name('ref-signatories');
});

Route::get('/account', AccountSettings::class)->name('account-settings')->middleware('auth');
