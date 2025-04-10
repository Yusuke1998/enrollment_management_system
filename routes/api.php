<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Public routes

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/academies', [ApiController::class, 'indexAcademies']);
Route::get('/academies/{id}', [ApiController::class, 'showAcademy']);
Route::get('/courses', [ApiController::class, 'indexCourses']);
Route::get('/courses/{id}', [ApiController::class, 'showCourse']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // User authentication
    Route::get('/user', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Academy management
    Route::post('/academies', [ApiController::class, 'storeAcademy']);
    Route::put('/academies/{id}', [ApiController::class, 'updateAcademy']);
    Route::delete('/academies/{id}', [ApiController::class, 'destroyAcademy']);

    // Course management
    Route::post('/courses', [ApiController::class, 'storeCourse']);
    Route::put('/courses/{id}', [ApiController::class, 'updateCourse']);
    Route::delete('/courses/{id}', [ApiController::class, 'destroyCourse']);

    // Enrollment management
    Route::post('/enrollments', [ApiController::class, 'storeEnrollment']);
    Route::put('/enrollments/{id}', [ApiController::class, 'updateEnrollment']);
    Route::delete('/enrollments/{id}', [ApiController::class, 'destroyEnrollment']);

    // Payment registration
    Route::post('payments', [ApiController::class, 'storePayment']);

    // Communication management
    Route::get('communications', [ApiController::class, 'getCommunications']);
    Route::post('communications', [ApiController::class, 'sendCommunication']);
});