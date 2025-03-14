<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingAccounts\Infrastructure\Persistence\Eloquent;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use MedineTech\Backoffice\Accounting\AccountingAccounts\Infrastructure\Persistence\Eloquent\AccountingAccountFilters;

final class AccountingAccountModel extends Model
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
        'creator_id',
        'updater_id',
        'company_id'
    ];

    public function scopeFromFilters(Builder $builder, array $filters): void
    {
        (new AccountingAccountFilters())->apply($builder, $filters);
    }
}
