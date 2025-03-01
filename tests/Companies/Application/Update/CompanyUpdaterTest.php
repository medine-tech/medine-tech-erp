<?php

declare(strict_types=1);

namespace Tests\Companies\Application\Update;

use MedineTech\Companies\Application\Update\CompanyUpdater;
use MedineTech\Companies\Application\Update\CompanyUpdaterRequest;
use MedineTech\Companies\Domain\CompanyRepository;
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

        $originalCompany->changeName($newName);

        /* @var CompanyRepository $companyRepository */
        $repository = $this->repository();
        $this->shouldFind($originalCompany->id(), $originalCompany);
        $this->shouldSave($originalCompany);

        $updater = new CompanyUpdater($repository);
        ($updater)(new CompanyUpdaterRequest(
            $originalCompany->id(),
            $newName
        ));

    }
}
