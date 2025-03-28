<?php

declare(strict_types=1);

namespace Tests\Backoffice\Companies\Application\Create;

use MedineTech\Backoffice\Companies\Application\Create\CompanyCreator;
use MedineTech\Backoffice\Companies\Application\Create\CompanyCreatorRequest;
use MedineTech\Backoffice\Companies\Domain\CompanyCreatedDomainEvent;
use MedineTech\Backoffice\Companies\Domain\CompanyRepository;
use MedineTech\Backoffice\CompanyUsers\Application\Create\CompanyUserCreator;
use MedineTech\Backoffice\CompanyUsers\Application\Create\CompanyUserCreatorRequest;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;
use Tests\Backoffice\Companies\Domain\CompanyMother;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

final class CompanyCreatorTest extends UnitTestCase
{
    #[Test]
    public function it_should_create_a_company(): void
    {
        $company = CompanyMother::create();

        $companyRepository = $this->mock(CompanyRepository::class);
        $companyRepository->shouldReceive('save')
            ->once()
            ->with($this->similarTo($company))
            ->andReturnNull();

        // create user company
        $userId = 1;
        $userCompanyCreator = $this->mock(CompanyUserCreator::class);
        $userCompanyCreator->shouldReceive('__invoke')
            ->once()
            ->with($this->similarTo(new CompanyUserCreatorRequest(
                $company->id(),
                $userId,
            )))
            ->andReturnNull();

        // event
        $eventBus = $this->eventBus();
        $domainEvent = new CompanyCreatedDomainEvent(
            $company->id(),
            $company->name(),
        );
        $this->shouldPublishDomainEvent($domainEvent);

        /* @var CompanyRepository&MockInterface $companyRepository */
        /* @var CompanyUserCreator&MockInterface $userCompanyCreator */
        $creator = new CompanyCreator(
            $companyRepository,
            $userCompanyCreator,
            $eventBus
        );

        ($creator)(new CompanyCreatorRequest(
            $company->id(),
            $company->name(),
            $userId
        ));
    }
}
