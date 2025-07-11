<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialiteController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();

            // Kiểm tra xem người dùng đã tồn tại chưa
            $user = User::where('provider', $provider)
                ->where('provider_id', $socialUser->id)
                ->first();

            if (!$user) {
                // Nếu người dùng chưa tồn tại, kiểm tra email
                $user = User::where('email', $socialUser->email)->first();

                if ($user) {
                    // Nếu email đã tồn tại, cập nhật provider và provider_id
                    $user->update([
                        'provider' => $provider,
                        'provider_id' => $socialUser->id,
                    ]);
                } else {
                    // Tạo người dùng mới
                    $user = User::create([
                        'name' => $socialUser->name ?? 'Unknown', // Đảm bảo name không null
                        'email' => $socialUser->email,
                        'provider' => $provider,
                        'provider_id' => $socialUser->id,
                        'password' => bcrypt(Str::random(16)), // Tạo mật khẩu ngẫu nhiên
                        'role' => 'tenant', // Gán vai trò mặc định
                        'phone' => $this->generateUniquePhone(), // Tạo số điện thoại tạm thời
                        'id_card' => $this->generateUniqueIdCard(), // Tạo số CMND/CCCD tạm thời
                        'address' => null, // Địa chỉ có thể null
                        'is_active' => true, // Trạng thái mặc định
                    ]);
                }
            }

            // Đăng nhập người dùng
            Auth::login($user, true);

            return redirect()->route('home');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Đăng nhập thất bại, vui lòng thử lại.');
        }
    }

    /**
     * Tạo số điện thoại duy nhất tạm thời
     */
    private function generateUniquePhone()
    {
        do {
            $phone = '0' . mt_rand(100000000, 999999999); // Tạo số điện thoại 10 chữ số
        } while (User::where('phone', $phone)->exists());

        return $phone;
    }

    /**
     * Tạo số CMND/CCCD duy nhất tạm thời
     */
    private function generateUniqueIdCard()
    {
        do {
            $idCard = mt_rand(100000000000, 999999999999); // Tạo số CMND/CCCD 12 chữ số
        } while (User::where('id_card', $idCard)->exists());

        return $idCard;
    }
}
