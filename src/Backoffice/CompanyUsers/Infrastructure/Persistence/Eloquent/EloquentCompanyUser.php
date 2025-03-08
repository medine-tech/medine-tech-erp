<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\CompanyUsers\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Model;

final class EloquentCompanyUser extends Model
{
    protected $table = 'company_users';
    protected $fillable = [
        'company_id',
        'user_id',
    ];
}
