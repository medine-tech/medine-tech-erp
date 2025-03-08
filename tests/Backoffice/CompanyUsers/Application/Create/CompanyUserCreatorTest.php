<?php

declare(strict_types=1);

namespace Tests\Backoffice\CompanyUsers\Application\Create;

use MedineTech\Backoffice\CompanyUsers\Application\Create\CompanyUserCreator;
use MedineTech\Backoffice\CompanyUsers\Application\Create\CompanyUserCreatorRequest;
use MedineTech\Backoffice\CompanyUsers\Domain\CompanyUserRepository;
use PHPUnit\Framework\Attributes\Test;
use Tests\Backoffice\CompanyUsers\Domain\CompanyUserMother;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

final class CompanyUserCreatorTest extends UnitTestCase
{
    #[Test]
    public function it_creates_a_new_company_user(): void
    {
        $companyUser = CompanyUserMother::create();

        $companyUserRepository = $this->mock(CompanyUserRepository::class);
        $companyUserRepository->shouldReceive("save")
            ->once()
            ->with($this->similarTo($companyUser))
            ->andReturnNull();

        /** @var CompanyUserRepository $companyUserRepository */
        $creator = new CompanyUserCreator(
            $companyUserRepository,
        );
        ($creator)(new CompanyUserCreatorRequest(
            $companyUser->companyId(),
            $companyUser->userId(),
        ));
    }
}
