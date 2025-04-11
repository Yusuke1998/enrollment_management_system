<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Livewire\EnrollFormSteps;
use App\Http\Controllers\{ApiController, CommunicationController};
use App\Models\Enrollment;

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
})->name('landing');

Route::get('/academy-details', function () {
    return view('livewire.academy-details');
});

Route::get('/course-details', function () {
    return view('livewire.course-details');
});

Route::get('/enroll-form', EnrollFormSteps::class);
Route::get('/inscripcion/confirmacion/{enrollment}', function ($enrollment) {
    $enrollment = Enrollment::find($enrollment);
    if (!$enrollment) {
        session()->flash('success', 'Inscripción no encontrada.');
        return redirect()->route('landing');
    }
    return view('livewire.confirmation', [
        'enrollment' => $enrollment,
    ]);
})->name('enrollment.confirmation');

// Custom logout route to clear the token
Route::post('/logout', function (Request $request) {
    if (Auth::check()) {
        Auth::user()->tokens()->delete();
    }
    
    session()->forget('auth_token');
    Auth::logout();
    
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    $cookie = cookie()->forget('auth_token');

    return redirect('/')->withCookie($cookie);
})->name('logout');

// Admin
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'admin'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::group(['middleware' => 'auth'], function () {
        Route::resource('communications', \App\Http\Controllers\CommunicationController::class);
        Route::get('communications/{communication}/resend', [CommunicationController::class, 'resend'])
            ->name('communications.resend');
    });
});
