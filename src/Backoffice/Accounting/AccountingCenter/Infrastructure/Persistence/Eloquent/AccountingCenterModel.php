<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingCenter\Infrastructure\Persistence\Eloquent;

use Stancl\Tenancy\Database\Models\Tenant;

final class AccountingCenterModel extends Tenant
{
    protected $table = 'backoffice__accounting__accounting_centers';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'code',
        'name',
        'description',
        'status',
        'parent_id',
        'company_id',
        'creator_id',
        'updater_id'
    ];
}
