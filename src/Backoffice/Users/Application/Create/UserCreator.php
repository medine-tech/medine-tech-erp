<?php
declare(strict_types=1);

namespace MedineTech\Backoffice\Users\Application\Create;

use MedineTech\Backoffice\CompanyUsers\Application\Create\CompanyUserCreator;
use MedineTech\Backoffice\CompanyUsers\Application\Create\CompanyUserCreatorRequest;
use MedineTech\Backoffice\Users\Domain\User;
use MedineTech\Backoffice\Users\Domain\UserRepository;
use MedineTech\Shared\Domain\Bus\Event\EventBus;

class UserCreator
{
    public function __construct(
        private readonly UserRepository $repository,
        private readonly CompanyUserCreator $companyUserCreator,
        private readonly EventBus $eventBus,
    ) {
    }

    public function __invoke(UserCreatorRequest $request): int
    {
        $id = $this->repository->nextId();

        $user = User::create(
            $id,
            $request->name(),
            $request->email(),
            $request->password()
        );

        $userId = $this->repository->save($user);

        ($this->companyUserCreator)(new CompanyUserCreatorRequest(
            $request->companyId(),
            $userId,
        ));

        $this->eventBus->publish(...$user->pullDomainEvents());

        return $userId;
    }
}
