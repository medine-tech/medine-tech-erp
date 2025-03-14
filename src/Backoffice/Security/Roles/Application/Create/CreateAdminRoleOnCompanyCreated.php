<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Security\Roles\Application\Create;

use MedineTech\Backoffice\Companies\Domain\CompanyCreatedDomainEvent;
use MedineTech\Backoffice\Security\Roles\Domain\Role;
use MedineTech\Backoffice\Security\Roles\Domain\RoleRepository;
use MedineTech\Shared\Domain\Bus\Event\DomainEventSubscriber;
use MedineTech\Shared\Domain\Bus\Event\EventBus;


final class CreateAdminRoleOnCompanyCreated implements DomainEventSubscriber
{
    private RoleCreator $roleCreator;
    private RoleRepository $roleRepository;
    private EventBus $roleEvent;

    public function __construct(
        RoleCreator $roleCreator,
        RoleRepository $roleRepository,
        EventBus $roleEvent
    )
    {
        $this->roleCreator = $roleCreator;
        $this->roleRepository = $roleRepository;
        $this->roleEvent = $roleEvent;
    }


    public function __invoke(CompanyCreatedDomainEvent $event): void
    {
        $creator = new RoleCreator($this->roleRepository, $this->roleEvent);

        ($creator)(new RoleCreatorRequest(
            "Super-Admin",
            "Rol de administrador con todos los permisos",
            2,
            $event->aggregateId()
        ));

    }

    public static function subscribedTo(): array
    {
        return [CompanyCreatedDomainEvent::class];
    }
}
