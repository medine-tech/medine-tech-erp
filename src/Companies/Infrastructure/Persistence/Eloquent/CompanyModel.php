<?php

declare(strict_types=1);

namespace MedineTech\Companies\Infrastructure\Persistence\Eloquent;

use Stancl\Tenancy\Database\Models\Tenant;
use Stancl\Tenancy\Database\Concerns\HasDomains;

final class CompanyModel extends Tenant
{
    use HasDomains;

    protected $table = 'companies';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];
}
