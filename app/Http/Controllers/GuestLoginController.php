<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class GuestLoginController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        $guest = User::where('email', 'guest@example.com')->first();

        if (! $guest) {
            return redirect()->route('login')->withErrors([
                'email' => 'ゲストユーザーが存在しません。管理者に連絡してください。',
            ]);
        }

        Auth::login($guest);

        request()->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }
}
