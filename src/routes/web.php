<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\AuthenticatedSessionController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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

Route::middleware(['web', 'auth',])->group(function () {
    Route::get('/', [AttendanceController::class, 'index']);
});
Route::group(['middleware' => 'guest'], function(){
    Route::get('/signIn', [AttendanceController::class, 'login'])->name('signIn');
});
Route::get('/register', [RegisteredUserController::class, 'create']);
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::get('/login', [AuthenticatedSessionController::class, 'store']);
Route::get('/logout', [AuthenticatedSessionController::class, 'destroy']);
Route::post('/punchIn', [AttendanceController::class, 'punchIn']);
Route::post('/punchOut', [AttendanceController::class, 'punchOut']);
Route::post('/breakIn', [AttendanceController::class, 'breakIn']);
Route::post('/breakOut', [AttendanceController::class, 'breakOut']);
Route::get('/attendance', [AttendanceController::class, 'attendance']);
Route::post('/subDay', [AttendanceController::class, 'subDay']);
Route::post('/addDay', [AttendanceController::class, 'addDay']);
Route::get('/users', [AttendanceController::class, 'users']);