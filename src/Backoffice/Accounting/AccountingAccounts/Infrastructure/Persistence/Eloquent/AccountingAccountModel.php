<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingAccounts\Infrastructure\Persistence\Eloquent;

use Stancl\Tenancy\Database\Models\Tenant;

final class AccountingAccountModel extends Tenant
{
    protected $table = 'backoffice__accounting__accounting_accounts';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'code',
        'name',
        'description',
        'type',
        'status',
        'parent_id',
        'company_id',
        'creator_id',
        'updater_id'
    ];
}
