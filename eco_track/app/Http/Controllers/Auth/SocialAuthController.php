<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->stateless()->user();

            $user = User::firstOrCreate(
                ['email' => $socialUser->getEmail()],
                [
                    'name' => $socialUser->getName(),
                    'password' => bcrypt(Str::random(24)),
                    'email_verified_at' => now(),
                    'role' => 'user',
                ]
            );

            Auth::login($user);

            return redirect('http://localhost:5174/social-success');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Google login failed', 'details' => $e->getMessage()], 500);
        }
    }
}
