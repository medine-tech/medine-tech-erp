<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use MedineTech\Auth\Companies\Domain\AuthCompanyRepository;
use MedineTech\Auth\Companies\Infrastructure\Persistence\Eloquent\EloquentAuthCompanyRepository;
use MedineTech\Auth\Users\Domain\AuthUserRepository;
use MedineTech\Auth\Users\Infrastructure\Persistence\Eloquent\EloquentAuthUserRepository;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccountRepository;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Infrastructure\Persistence\Eloquent\EloquentAccountingAccountRepository;
use MedineTech\Backoffice\Accounting\AccountingCenter\Domain\AccountingCenterRepository;
use MedineTech\Backoffice\Accounting\AccountingCenter\Infrastructure\Persistence\Eloquent\EloquentAccountingCenterRepository;
use MedineTech\Backoffice\Companies\Domain\CompanyRepository;
use MedineTech\Backoffice\Companies\Infrastructure\Persistence\Eloquent\EloquentCompanyRepository;
use MedineTech\Backoffice\CompanyUsers\Domain\CompanyUserRepository;
use MedineTech\Backoffice\CompanyUsers\Infrastructure\Persistence\Eloquent\EloquentCompanyUserRepository;
use MedineTech\Backoffice\FirstCompanies\Domain\FirstCompanyRepository;
use MedineTech\Backoffice\FirstCompanies\Infrastructure\Persistence\Eloquent\EloquentFirstCompanyRepository;
use MedineTech\Backoffice\Roles\Application\Create\CreateAdminRoleOnCompanyCreated;
use MedineTech\Backoffice\Security\Roles\Domain\RoleRepository;
use MedineTech\Backoffice\Security\Roles\Infrastructure\Persistence\EloquentRoleRepository;
use MedineTech\Backoffice\Security\RolePermissions\Domain\RolePermissionRepository;
use MedineTech\Backoffice\Security\RolePermissions\Infrastructure\Persistence\Eloquent\EloquentRolePermissionRepository;
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
        // Define an array of subscribers implementing DomainEventSubscriber.
        // This avoids scanning directories at runtime.
        $eventSubscribers = [
            CreateAdminRoleOnCompanyCreated::class,
            // Add other subscribers here.
        ];


        // Tag the subscribers for lazy-loading.
        $this->app->tag($eventSubscribers, 'event.subscribers');

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
        $this->app->bind(RoleRepository::class, EloquentRoleRepository::class);
        $this->app->bind(AccountingAccountRepository::class, EloquentAccountingAccountRepository::class);
        $this->app->bind(AccountingCenterRepository::class, EloquentAccountingCenterRepository::class);
        $this->app->bind(RolePermissionRepository::class, EloquentRolePermissionRepository::class);
        $this->app->bind(AuthCompanyRepository::class, EloquentAuthCompanyRepository::class);
        $this->app->bind(AuthUserRepository::class, EloquentAuthUserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url') . "/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });

        // Implicitly grant "Super-Admin" role all permission checks using can()
        Gate::before(function ($user, $ability) {
            if ($user->hasRole('Super-Admin')) {
                return true;
            }

            return null;
        });
    }
}
