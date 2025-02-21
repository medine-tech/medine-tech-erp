<?php

declare(strict_types=1);

namespace MedineTech\Companies\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Models\Tenant;

final class CompanyModel extends Tenant
{
    protected $table = 'companies';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
//        'name',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];
}
