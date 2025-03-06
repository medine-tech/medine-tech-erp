<?php

declare(strict_types=1);

namespace Tests\Backoffice\Companies\Application\Update;

use MedineTech\Backoffice\Companies\Application\Update\CompanyUpdater;
use MedineTech\Backoffice\Companies\Application\Update\CompanyUpdaterRequest;
use MedineTech\Backoffice\Companies\Domain\CompanyNotFound;
use MedineTech\Backoffice\Companies\Domain\CompanyRepository;
use MedineTech\Shared\Domain\ValueObject\Uuid;
use PHPUnit\Framework\Attributes\Test;
use Tests\Companies\CompanyUnitTestCase;
use Tests\Companies\Domain\CompanyMother;

final class CompanyUpdaterTest extends CompanyUnitTestCase
{
    #[test]
    public function it_should_update_a_company(): void
    {
        $id = Uuid::random()->value();
        $originalCompany = CompanyMother::create(
            $id
        );

        $newName = 'new name';


        /* @var CompanyRepository $companyRepository */
        $repository = $this->repository();
        $this->shouldFind($originalCompany->id(), $originalCompany);
        $this->shouldSave($originalCompany);

        $updater = new CompanyUpdater($repository);
        ($updater)(new CompanyUpdaterRequest(
            $originalCompany->id(),
            $newName
        ));

        $this->assertEquals($newName, $originalCompany->name());

    }

    #[test]
    public function it_should_throw_exception_when_company_not_found(): void
    {
        $id = Uuid::random()->value();
        $this->shouldNotFind($id);

        $updater = new CompanyUpdater($this->repository());

        $this->expectException(CompanyNotFound::class);
        ($updater)(new CompanyUpdaterRequest($id, 'new name'));
    }
}
