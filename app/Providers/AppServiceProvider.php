<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;
use MedineTech\Users\Domain\UserRepository;
use MedineTech\Users\Infrastructure\Persistence\EloquentUserRepository;
use MedineTech\Companies\Domain\CompanyRepository;
use MedineTech\Companies\Infrastructure\Persistence\Eloquent\EloquentCompanyRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepository::class, EloquentUserRepository::class);
        $this->app->bind(CompanyRepository::class, EloquentCompanyRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });
    }
}
