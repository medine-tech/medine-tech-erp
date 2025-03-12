<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingCenter\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use MedineTech\Backoffice\CompanyUsers\Infrastructure\Persistence\Eloquent\CompanyUserModel;

final class AccountingCenterModel extends Model
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
        'creator_id',
        'updater_id',
        'company_id'
    ];

    public function company_users(): HasMany
    {
        return $this->hasMany(CompanyUserModel::class, 'accounting_center_id', 'id');
    }

    public function scopeFromFilters(Builder $builder, array $filters): void
    {
        (new AccountingCenterFilters())->apply($builder, $filters);
    }
}
