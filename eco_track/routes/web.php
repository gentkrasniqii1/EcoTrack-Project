<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialAuthController;

Route::get('/', function () {
    return view('welcome');
});

// -----------------------------
// 🌐 OAuth Login Routes (Google/Facebook)
// -----------------------------
// IMPORTANT: Përdor 'web' middleware që të funksionojë session për Socialite
Route::get('/auth/{provider}', [SocialAuthController::class, 'redirect']);
Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback']);
