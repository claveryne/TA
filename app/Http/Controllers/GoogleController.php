<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            // pakai stateless() jika mengalami masalah session,
            // untuk web normal bisa juga ->user() tanpa stateless()
            $googleUser = Socialite::driver('google')->user();
            $email = $googleUser->getEmail();

            // Create atau update user
            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $googleUser->getName(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'password' => bcrypt(uniqid('google_', true)),
                ]
            );

            Auth::login($user);

            return redirect()->route('profile');
        } catch (\Exception $e) {
            Log::error('Google login error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Login dengan Google gagal.');
        }
    }
}
