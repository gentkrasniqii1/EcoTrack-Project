<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth; // <-- Needed for Auth::guard()
use App\Models\User;                  // <-- Needed for User model
use Illuminate\Support\Str;            // <-- Needed for random password

// -----------------------------
// 🔐 JWT Auth Routes
// -----------------------------

// Login & Refresh
Route::post('/login', [AuthController::class, 'login']);
Route::post('/refresh', [AuthController::class, 'refresh']);

// -----------------------------
// 🌐 Google OAuth Routes
// -----------------------------

Route::get('/auth/google', function () {
    return Socialite::driver('google')->stateless()->redirect();
});

Route::get('/auth/google/callback', function () {
    $googleUser = Socialite::driver('google')->stateless()->user();

    $user = User::firstOrCreate(
        ['email' => $googleUser->getEmail()],
        [
            'name' => $googleUser->getName(),
            'google_id' => $googleUser->getId(),
            'password' => bcrypt(Str::random(24)),
            'email_verified_at' => now(), // Optional: Automatically mark email as verified
            'role' => 'user',             // Optional: default role
        ]
    );

    $token = Auth::guard('api')->login($user);

    return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => auth('api')->factory()->getTTL() * 60,
        'user' => $user,
    ]);
});

// -----------------------------
// 🔐 Routes that require JWT Authentication
// -----------------------------

Route::middleware('auth:api')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Role-based access
    Route::middleware('role:admin')->get('/admin-dashboard', function () {
        return response()->json(['message' => 'Mirësevjen admin!']);
    });

    Route::middleware('role:user')->get('/user-dashboard', function () {
        return response()->json(['message' => 'Mirësevjen përdorues!']);
    });

    // Email verification trigger
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return response()->json(['message' => 'Verification link sent!']);
    })->middleware('throttle:6,1');
});

// Final email verification route
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/email-verified-success');
})->middleware(['auth:api', 'signed'])->name('verification.verify');
