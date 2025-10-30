<?php

namespace App\Observers;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use App\Models\User;

class AuthenticationObserver
{
    public function handle($event)
    {
        if ($event instanceof Login && $event->user) {
            User::where('id', $event->user->id)->update([
                'is_online' => true,
                'last_login_at' => now()
            ]);
        }
        
        if ($event instanceof Logout && $event->user) {
            User::where('id', $event->user->id)->update([
                'is_online' => false
            ]);
        }
    }
}