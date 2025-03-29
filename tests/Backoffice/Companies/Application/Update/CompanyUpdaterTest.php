<?php

declare(strict_types=1);

namespace Tests\Backoffice\Companies\Application\Update;

use MedineTech\Backoffice\Companies\Application\Update\CompanyUpdater;
use MedineTech\Backoffice\Companies\Application\Update\CompanyUpdaterRequest;
use MedineTech\Backoffice\Companies\Domain\CompanyNotFound;
use MedineTech\Backoffice\Companies\Domain\CompanyRepository;
use MedineTech\Shared\Domain\ValueObject\Uuid;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;
use Tests\Backoffice\Companies\CompanyUnitTestCase;
use Tests\Backoffice\Companies\Domain\CompanyMother;


final class CompanyUpdaterTest extends CompanyUnitTestCase
{
    #[Test]
    public function it_should_update_a_company(): void
    {
        $id = Uuid::random()->value();
        $originalCompany = CompanyMother::create(
            $id
        );

        $newName = 'new name';

        /** @var CompanyRepository&MockInterface $companyRepository */
        $companyRepository = $this->repository();
        $this->shouldFind($originalCompany->id(), $originalCompany);
        $this->shouldSave($originalCompany);

        $updater = new CompanyUpdater($companyRepository);
        ($updater)(new CompanyUpdaterRequest(
            $originalCompany->id(),
            $newName
        ));

        $this->assertEquals($newName, $originalCompany->name());

    }

    #[Test]
    public function it_should_throw_exception_when_company_not_found(): void
    {
        $id = Uuid::random()->value();
        $this->shouldNotFind($id);

        /** @var CompanyRepository&MockInterface $companyRepository */
        $companyRepository = $this->repository();
        $updater = new CompanyUpdater($companyRepository);

        $this->expectException(CompanyNotFound::class);
        ($updater)(new CompanyUpdaterRequest($id, 'new name'));
    }
}
