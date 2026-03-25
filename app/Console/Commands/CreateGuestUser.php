<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateGuestUser extends Command
{
    protected $signature = 'guest:create';

    protected $description = 'ゲストユーザー (guest@example.com) を作成または初期化します';

    public function handle(): void
    {
        User::updateOrCreate(
            ['email' => 'guest@example.com'],
            [
                'name' => 'Guest',
                'password' => Hash::make('guest-password-' . config('app.key')),
                'email_verified_at' => now(),
            ]
        );

        $this->info('ゲストユーザーを作成しました: guest@example.com');
    }
}
