<?php
declare(strict_types=1);

namespace Tests\Backoffice\Users;

use MedineTech\Backoffice\Users\Domain\UserRepository;
use Mockery\MockInterface;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

/**
 * @method UserRepository&MockInterface mock(string $class)
 */
abstract class UserUnitTestCase extends UnitTestCase
{
    private ?MockInterface $repository = null;

    protected function repository(): MockInterface
    {
        if ($this->repository !== null) {
            return $this->repository;
        }

        return $this->repository = $this->mock(UserRepository::class);
    }

    protected function shouldSaveUser($user): void
    {
        $this->repository()
            ->shouldReceive('save')
            ->once()
            ->with($this->similarTo($user))
            ->andReturn($user->id());
    }

    protected function shouldFindUser(int $id, $user): void
    {
        $this->repository()
            ->shouldReceive('find')
            ->once()
            ->with($this->similarTo($id))
            ->andReturn($user);
    }
}
