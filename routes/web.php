<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('livewire.landing');
});

Route::get('/academy-details', function () {
    return view('livewire.academy-details');
});

Route::get('/course-details', function () {
    return view('livewire.course-details');
});

Route::get('/enroll-form', function () {
    return view('livewire.enroll-form');
});

// Custom logout route to clear the token
Route::post('/logout', function (Request $request) {
    // Revocar todos los tokens de API si el usuario está autenticado
    if (Auth::check()) {
        Auth::user()->tokens()->delete();
    }
    
    // Clear the token from the session
    session()->forget('auth_token');
    
    // Logout the user
    Auth::logout();
    
    // Invalidate the session
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    
    // Crear una cookie expirada para eliminar la cookie del token
    $cookie = cookie()->forget('auth_token');
    
    // Redirect to home
    return redirect('/')->withCookie($cookie);
})->name('logout');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'admin'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
