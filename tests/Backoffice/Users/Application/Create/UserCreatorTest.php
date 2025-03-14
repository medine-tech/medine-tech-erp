<?php

declare(strict_types=1);

namespace Tests\Backoffice\Users\Application\Create;

use MedineTech\Backoffice\CompanyUsers\Application\Create\CompanyUserCreator;
use MedineTech\Backoffice\CompanyUsers\Application\Create\CompanyUserCreatorRequest;
use MedineTech\Backoffice\Users\Application\Create\UserCreator;
use MedineTech\Backoffice\Users\Application\Create\UserCreatorRequest;
use MedineTech\Backoffice\Users\Domain\UserCreatedDomainEvent;
use MedineTech\Backoffice\Users\Domain\UserRepository;
use PHPUnit\Framework\Attributes\Test;
use Tests\Backoffice\Users\Domain\UserMother;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

final class UserCreatorTest extends UnitTestCase
{
    #[Test]
    public function it_should_create_user(): void
    {
        $userId = 1;
        $companyId = "company-id";
        $user = UserMother::create(id: $userId);

        $userRepository = $this->mock(UserRepository::class);

        $userRepository->shouldReceive('nextId')
            ->once()
            ->andReturn($userId);

        $userRepository->shouldReceive('save')
            ->once()
            ->with($this->similarTo($user))
            ->andReturn($userId);

        $request = new UserCreatorRequest(
            $user->name(),
            $user->email(),
            $user->password(),
            $companyId
        );

        // create user company
        $userCompanyCreator = $this->mock(CompanyUserCreator::class);
        $userCompanyCreator->shouldReceive('__invoke')
            ->once()
            ->with($this->similarTo(new CompanyUserCreatorRequest(
                $companyId,
                $userId,
            )))
            ->andReturnNull();

        // event
        $eventBus = $this->eventBus();
        $event = new UserCreatedDomainEvent(
            (string)$userId,
            $user->name(),
            $user->email(),
            $user->password(),
        );
        $this->shouldPublishDomainEvent($event);

        /** @var UserRepository $userRepository */
        /** @var CompanyUserCreator $userCompanyCreator */
        $creator = new UserCreator(
            $userRepository,
            $userCompanyCreator,
            $eventBus
        );
        ($creator)($request);
    }
}
