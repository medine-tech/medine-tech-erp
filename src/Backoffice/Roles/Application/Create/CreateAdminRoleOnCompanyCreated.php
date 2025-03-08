<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Roles\Application\Create;

use MedineTech\Backoffice\Companies\Domain\CompanyCreatedDomainEvent;
use MedineTech\Shared\Domain\Bus\Event\DomainEventSubscriber;

final class CreateAdminRoleOnCompanyCreated implements DomainEventSubscriber
{
    public function __invoke(CompanyCreatedDomainEvent $event): void
    {
//        dd("CreateAdminRoleOnCompanyCreated");
    }

    public static function subscribedTo(): array
    {
        return [CompanyCreatedDomainEvent::class];
    }
}
