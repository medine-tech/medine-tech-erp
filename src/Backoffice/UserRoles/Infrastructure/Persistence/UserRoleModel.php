<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\UserRoles\Infrastructure\Persistence;

use Illuminate\Database\Eloquent\Model;

final class UserRoleModel extends Model
{
    protected $table = "model_has_roles";
    protected $fillable = ["role_id", "model_id", "model_type", "company_id"];
    public $timestamps = false;
}
