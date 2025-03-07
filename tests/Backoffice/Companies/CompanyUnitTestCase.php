<?php

declare(strict_types=1);

namespace Tests\Backoffice\Companies;

use MedineTech\Backoffice\Companies\Domain\Company;
use MedineTech\Backoffice\Companies\Domain\CompanyRepository;
use Mockery\MockInterface;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

abstract class CompanyUnitTestCase extends UnitTestCase
{
    private ?MockInterface $repository = null;

    public function repository(): MockInterface
    {
        if ($this->repository) {
            return $this->repository;
        }

        return $this->repository = $this->mock(CompanyRepository::class);
    }

    protected function shouldSave(Company $company): void
    {
        $this->repository()
            ->shouldReceive('save')
            ->once()
            ->with($this->similarTo($company))
            ->andReturnNull();
    }

    protected function shouldFind(string $id, ?Company $company): void
    {
        $this->repository()
            ->shouldReceive('find')
            ->once()
            ->with($this->similarTo($id))
            ->andReturn($company);
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
