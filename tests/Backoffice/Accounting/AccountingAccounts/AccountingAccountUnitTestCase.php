<?php

declare(strict_types=1);

namespace Tests\Backoffice\Accounting\AccountingAccounts;

use MedineTech\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccount;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccountRepository;
use Mockery\MockInterface;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

abstract class AccountingAccountUnitTestCase extends UnitTestCase
{
    private ?MockInterface $repository = null;

    public function repository(): MockInterface
    {
        if ($this->repository) {
            return $this->repository;
        }

        return $this->repository = $this->mock(AccountingAccountRepository::class);
    }

    protected function shouldSave(AccountingAccount $accountingAccount): void
    {
        $this->repository()
            ->shouldReceive('save')
            ->once()
            ->with($this->similarTo($accountingAccount))
            ->andReturnNull();
    }

    protected function shouldFind(string $id, ?AccountingAccount $accountingAccount): void
    {
        $this->repository()
            ->shouldReceive('find')
            ->once()
            ->with($this->similarTo($id))
            ->andReturn($accountingAccount);
    }

    protected function shouldNotFind(string $id): void
    {
        $this->repository()
            ->shouldReceive('find')
            ->once()
            ->with($this->similarTo($id))
            ->andReturnNull();
    }
}
