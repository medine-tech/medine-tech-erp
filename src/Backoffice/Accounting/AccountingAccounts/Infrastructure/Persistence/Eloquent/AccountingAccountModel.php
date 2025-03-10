<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingAccounts\Infrastructure\Persistence\Eloquent;

use Stancl\Tenancy\Database\Models\Tenant;

final class AccountingAccountModel extends Tenant
{
    protected $table = 'accounting_accounts';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'code',
        'type',
        'parent_id',
        'status',
        'company_id',
    ];
}
