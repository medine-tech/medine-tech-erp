<?php
declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingAccounts\Application\Create;

use MedineTech\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccount;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Domain\AccountingAccountRepository;
use MedineTech\Shared\Domain\Bus\Event\EventBus;

class AccountingAccountCreator
{
    public function __construct(
        private readonly AccountingAccountRepository $repository,
        private readonly EventBus $eventBus
    )
    {
    }

    public function __invoke(AccountingAccountCreatorRequest $request): void
    {
        $accountingAccount = AccountingAccount::create(
            $request->id(),
            $request->code(),
            $request->name(),
            $request->description(),
            $request->type(),
            $request->parentId(),
            $request->creatorId(),
            $request->companyId()
        );

        $this->repository->save($accountingAccount);
        $this->eventBus->publish(...$accountingAccount->pullDomainEvents());
    }
}
