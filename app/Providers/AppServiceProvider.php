<?php

namespace App\Providers;

use storage;
use Carbon\CarbonInterval;
use Laravel\Passport\Passport;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Augmenter le temps d'exécution maximum
        set_time_limit(300);
        \Illuminate\Support\Facades\Blade::anonymousComponentPath(resource_path('views/layouts'), 'layouts');
        \Illuminate\Support\Facades\Blade::anonymousComponentPath(resource_path('views/components'), 'components');
        Passport::loadKeysFrom(storage_path());
        Passport::enablePasswordGrant();
        Passport::tokensExpireIn(now()->addMinutes(60));
        Passport::refreshTokensExpireIn(now()->addDays(30));
        Passport::personalAccessTokensExpireIn(CarbonInterval::months(6));

        // Enregistrer l'observateur d'utilisateur
        \App\Models\User::observe(\App\Observers\UserObserver::class);

        // Gérer les événements d'authentification
        $events = $this->app['events'];
        
        $events->listen(Login::class, function ($event) {
            $user = $event->user;
            $user->is_online = true;
            $user->last_login_at = now();
            $user->save();
        });
        
        $events->listen(Logout::class, function ($event) {
            $user = $event->user;
            $user->is_online = false;
            $user->save();
        });
    }
}
