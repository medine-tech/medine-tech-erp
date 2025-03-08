<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;
use MedineTech\Backoffice\Companies\Domain\CompanyRepository;
use MedineTech\Backoffice\Companies\Infrastructure\Persistence\Eloquent\EloquentCompanyRepository;
use MedineTech\Backoffice\CompanyUsers\Domain\CompanyUserRepository;
use MedineTech\Backoffice\CompanyUsers\Infrastructure\Persistence\Eloquent\EloquentCompanyUserRepository;
use MedineTech\Backoffice\FirstCompanies\Domain\FirstCompanyRepository;
use MedineTech\Backoffice\FirstCompanies\Infrastructure\Persistence\Eloquent\EloquentFirstCompanyRepository;
use MedineTech\Backoffice\Users\Domain\UserRepository;
use MedineTech\Backoffice\Users\Infrastructure\Persistence\Eloquent\EloquentUserRepository;
use MedineTech\Shared\Domain\Bus\Event\EventBus;
use MedineTech\Shared\Infrastructure\Bus\Event\InMemory\InMemorySymfonyEventBus;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // event bus
        $this->app->singleton(EventBus::class, function ($app) {
            $subscribers = $app->tagged('event.subscribers');
            return new InMemorySymfonyEventBus($subscribers);
        });

        // modules
        $this->app->bind(UserRepository::class, EloquentUserRepository::class);
        $this->app->bind(CompanyRepository::class, EloquentCompanyRepository::class);
        $this->app->bind(CompanyUserRepository::class, EloquentCompanyUserRepository::class);
        $this->app->bind(FirstCompanyRepository::class, EloquentFirstCompanyRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url') . "/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });
    }
}
