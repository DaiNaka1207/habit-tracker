<?php

namespace App\Jobs;

use App\Mail\HabitReminderMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendHabitReminder implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly User $user
    ) {}

    public function handle(): void
    {
        Mail::to($this->user)->send(new HabitReminderMail($this->user));
    }
}
