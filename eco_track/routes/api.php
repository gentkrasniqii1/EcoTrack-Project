<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\RecyclingReportController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\AdminController;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

// 🔓 PUBLIC ROUTES
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/refresh', fn () => response()->json([
    'access_token' => auth()->refresh(),
    'token_type' => 'bearer',
    'expires_in' => auth()->factory()->getTTL() * 60,
]));

// OAuth
Route::get('/auth/google', fn () => Socialite::driver('google')->stateless()->redirect());
Route::get('/auth/google/callback', function () {
    $googleUser = Socialite::driver('google')->stateless()->user();
    $user = User::firstOrCreate(
        ['email' => $googleUser->getEmail()],
        [
            'name' => $googleUser->getName(),
            'google_id' => $googleUser->getId(),
            'password' => bcrypt(Str::random(24)),
            'email_verified_at' => now(),
            'role' => 'user',
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

// Email verification
Route::get('/email/verify/{id}/{hash}', fn (EmailVerificationRequest $request) => $request->fulfill())
    ->middleware(['auth:api', 'signed'])->name('verification.verify');

// 🔐 AUTHENTICATED ROUTES
Route::middleware('auth:api')->group(function () {
    // User auth
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Email verification
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return response()->json(['message' => 'Verification link sent!']);
    })->middleware('throttle:6,1');

    // Admin-only
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/users-count', [AdminController::class, 'countUsers']);
        Route::get('/reports-count', [AdminController::class, 'countReports']);
        Route::get('/users', [AdminController::class, 'listUsers']);
        Route::put('/users/{id}/toggle-role', [AdminController::class, 'toggleUserRole']);
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser']);
        Route::get('/reports', [AdminController::class, 'listReports']);
    });

    // Notifications
    Route::get('/notifications', fn () => auth()->user()->notifications()->latest()->take(10)->get());
    Route::post('/notifications/{id}/mark-as-read', fn ($id) => tap(
        auth()->user()->notifications()->findOrFail($id),
        fn ($n) => $n->markAsRead()
    )->delete());

    Route::delete('/notifications/{id}', fn ($id) => auth()->user()->notifications()->findOrFail($id)->delete());

    // Messages
    Route::get('/messages', [MessageController::class, 'index']);
    Route::post('/messages', [MessageController::class, 'store']);

    // Reports (for both roles)
    Route::apiResource('recycling-reports', RecyclingReportController::class);
});
