<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Security\Roles\Infrastructure\Persistence;

use Exception;
use Illuminate\Support\Facades\DB;
use MedineTech\Backoffice\Security\Roles\Domain\RoleRepository;
use MedineTech\Backoffice\Security\Roles\Domain\Role;
use RuntimeException;

final class EloquentRoleRepository implements RoleRepository
{
    public function save(Role $role): void
    {
        try {
            $data = [
                'id' => $role->id(),
                'code' => $role->code(),
                'name' => $role->name(),
                'description' => $role->description(),
                'status' => $role->status(),
                'creator_id' => $role->creatorId(),
                'company_id' => $role->companyId(),
            ];

            RoleModel::updateOrCreate(
                ['id' => $role->id()],
                $data
            );
        } catch (Exception $e) {
            throw new RuntimeException("Failed to save accounting account: " . $e->getMessage(), 0, $e);
        }
    }

    public function nextCode(string $company_id): string
    {
        $rol = "ROL";
        $year = date('y');

        $lastCode = DB::table('roles')
            ->where('company_id', $company_id)
            ->where('code', 'like', $rol . $year . '%')
            ->orderBy('id', 'desc')
            ->value('code');

        $lastValue = $lastCode ? substr($lastCode, -6) : '000000';

        $nextValueInt = intval($lastValue) + 1;
        $nextValue = str_pad((string)$nextValueInt, 6, '0', STR_PAD_LEFT);

        $newCode = $rol . $year . $nextValue;

        return $newCode;
    }
}
