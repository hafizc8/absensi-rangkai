<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AttendanceController;

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

Route::post('login', [AuthController::class, 'authenticate']);
Route::post('change-password', [AuthController::class, 'changePassword']);
Route::post('change-display-pic', [AuthController::class, 'changeDisplayPicture']);

Route::get('get-attendance-today/{userid}', [AttendanceController::class, 'getAttendanceToday']);
Route::post('save-attendance', [AttendanceController::class, 'saveAttendance']);
Route::get('get-attendance-history/{userid}', [AttendanceController::class, 'getAttendanceHistory']);
