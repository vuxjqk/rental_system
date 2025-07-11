<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();

            // Tìm hoặc tạo người dùng trong cơ sở dữ liệu
            $user = User::firstOrCreate(
                ['email' => $socialUser->getEmail()],
                [
                    'name' => $socialUser->getName(),
                    'provider_id' => $socialUser->getId(),
                    'provider' => $provider,
                    'password' => bcrypt(Str::random(16)), // Mật khẩu ngẫu nhiên
                ]
            );

            // Đăng nhập người dùng
            Auth::login($user, true);

            return redirect()->route('home'); // Chuyển hướng sau khi đăng nhập
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['error' => 'Đăng nhập thất bại']);
        }
    }
}
