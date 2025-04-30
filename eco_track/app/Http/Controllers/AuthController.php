<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use App\Models\User;
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);


class AuthController extends Controller
{
    /**
     * Login me email dhe password
     */
    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
    
        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'google_id' => $googleUser->getId(),
                'password' => bcrypt(Str::random(24)),
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
    }
    
     public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Email ose fjalëkalim i gabuar!'], 401);
        }

        $user = Auth::user();

        // Nëse përdor verifikim email-i
        if (method_exists($user, 'hasVerifiedEmail') && !$user->hasVerifiedEmail()) {
            return response()->json(['error' => 'Email-i nuk është verifikuar!'], 403);
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ]
        ]);
    }

    /**
     * Kthe informacionin e përdoruesit të autentikuar
     */
    public function me()
    {
        return response()->json(Auth::user());
    }

    /**
     * Logout dhe invalidim i token-it
     */
    public function logout(Request $request)
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json(['message' => 'U çregjistrove me sukses']);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Nuk mund të invalidojmë tokenin'], 500);
        }
    }

    /**
     * Refresh token (opsionale)
     */
    public function refresh()
    {
        try {
            $newToken = JWTAuth::parseToken()->refresh();
            return response()->json([
                'access_token' => $newToken,
                'token_type' => 'bearer',
                'expires_in' => JWTAuth::factory()->getTTL() * 60,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Nuk mund të rifreskojmë tokenin'], 401);
        }

 
 
    }


    public function register(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users',
        'phone' => 'required|string|max:20',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
    ]);

    $user = User::create([
        'name' => $validated['name'],
        'username' => $validated['username'],
        'phone' => $validated['phone'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']),
        'role' => 'user',
    ]);

    return response()->json(['message' => 'Registration successful'], 201);
}

}
