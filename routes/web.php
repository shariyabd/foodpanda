<?php

use App\Http\Controllers\Auth\SsoAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [SsoAuthController::class, 'showLogin'])->name('login');
Route::get('/auth/redirect', [SsoAuthController::class, 'redirect'])->name('sso.redirect');
Route::get('/auth/callback', [SsoAuthController::class, 'callback'])->name('sso.callback');
Route::get('/auth/logged-out', [SsoAuthController::class, 'loggedOut'])->name('sso.logged-out');

Route::middleware('sso.auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard', [
            'user' => session('sso_user'),
        ]);
    })->name('dashboard');

    Route::post('/logout', [SsoAuthController::class, 'logout'])->name('logout');
});