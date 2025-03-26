<?php

declare(strict_types=1);

namespace Tests\Auth\Users;

use MedineTech\Auth\Users\Domain\AuthUser;
use MedineTech\Auth\Users\Domain\AuthUserRepository;
use Mockery\MockInterface;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

abstract class AuthUserUnitTestCase extends UnitTestCase
{
    private ?MockInterface $repository = null;

    public function repository(): MockInterface
    {
        if ($this->repository) {
            return $this->repository;
        }

        return $this->repository = $this->mock(AuthUserRepository::class);
    }

    protected function shouldFind(int $id, ?AuthUser $company): void
    {
        $this->repository()
            ->shouldReceive('find')
            ->once()
            ->with($this->similarTo($id))
            ->andReturn($company);
    }
}
