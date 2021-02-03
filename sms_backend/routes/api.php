<?php

use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\StudentController;
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

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);
     
Route::middleware('auth:api')->group( function () {
    Route::get('get-students', [StudentController::class, 'getStudentInformation']);
    Route::post('get-single-student', [StudentController::class, 'getSingleStudent']);
    Route::post('delete-single-student', [StudentController::class, 'deleteStudent']);

});