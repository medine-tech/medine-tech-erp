<?php
declare(strict_types=1);

namespace Tests\Backoffice\Accounting\AccountingCenter;

use MedineTech\Backoffice\Accounting\AccountingCenter\Domain\AccountingCenter;
use MedineTech\Backoffice\Accounting\AccountingCenter\Domain\AccountingCenterRepository;
use Mockery\MockInterface;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

/**
 * @method AccountingCenterRepository&MockInterface mock(string $class)
 */
abstract class AccountingCenterUnitTestCase extends UnitTestCase
{
    private ?MockInterface $repository = null;

    protected function repository(): MockInterface
    {
        if ($this->repository !== null) {
            return $this->repository;
        }

        return $this->repository = $this->mock(AccountingCenterRepository::class);
    }

    protected function shouldFind(string $id, ?AccountingCenter $accountingCenter): void
    {
        $this->repository()
            ->shouldReceive('find')
            ->once()
            ->with($this->similarTo($id))
            ->andReturn($accountingCenter);
    }

    protected function shouldSave(AccountingCenter $accountingCenter): void
    {
        $this->repository()
            ->shouldReceive('save')
            ->once()
            ->with($this->similarTo($accountingCenter))
            ->andReturnNull();
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
