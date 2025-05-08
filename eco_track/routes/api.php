<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RecyclingReportController;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

// -----------------------------
// ✅ PUBLIC ROUTES (No Auth Required)
// -----------------------------

// Auth (JWT)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/refresh', function () {
    return response()->json([
        'access_token' => auth()->refresh(),
        'token_type' => 'bearer',
        'expires_in' => auth()->factory()->getTTL() * 60
    ]);
});

use App\Http\Controllers\Api\MessageController;

Route::get('/messages', [MessageController::class, 'index']);
Route::post('/messages', [MessageController::class, 'store']);


Route::get('/notifications', function () {
    return auth()->user()->notifications()->latest()->take(10)->get();
});

Route::middleware('auth:api')->group(function () {
    Route::post('/notifications/{id}/mark-as-read', function ($id) {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        return response()->json(['message' => 'Marked as read']);
    });

    Route::delete('/notifications/{id}', function ($id) {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->delete();
        return response()->json(['message' => 'Deleted']);
    });
});

// Google OAuth
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

// Final email verification after link click
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return response()->json(['message' => 'Email verified']);
})->middleware(['auth:api', 'signed'])->name('verification.verify');

// -----------------------------
// 🔐 AUTHENTICATED ROUTES (JWT Required)
// -----------------------------
Route::middleware('auth:api')->group(function () {

    // General user auth actions
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Email verification trigger
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return response()->json(['message' => 'Verification link sent!']);
    })->middleware('throttle:6,1');

    // -------------------------
    // 🛡️ ADMIN-ONLY ROUTES
    // -------------------------
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/users-count', [AdminController::class, 'countUsers']);
        Route::get('/reports-count', [AdminController::class, 'countReports']);
        Route::get('/users', [AdminController::class, 'listUsers']);
        Route::put('/users/{id}/toggle-role', [AdminController::class, 'toggleUserRole']);
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser']);
        Route::get('/reports', [AdminController::class, 'listReports']);
    });

    // -------------------------
    // 👤 USER-ONLY ROUTES
    // -------------------------
    Route::middleware('role:user')->get('/user-dashboard', function () {
        return response()->json(['message' => 'Mirësevjen përdorues!']);
    });

    // -------------------------
    // ♻️ RECYCLING REPORTS (CRUD)
    // -------------------------
    Route::apiResource('recycling-reports', RecyclingReportController::class);
});
