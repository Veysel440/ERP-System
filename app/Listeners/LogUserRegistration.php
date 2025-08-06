<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Support\Facades\Log;

class LogUserRegistration
{
    public function handle(UserRegistered $event)
    {
        Log::info('Kullanıcı kayıt oldu.', [
            'user_id'    => $event->user->id,
            'name'       => $event->user->name,
            'email'      => $event->user->email,
            'registered' => now(),
        ]);
    }
}
