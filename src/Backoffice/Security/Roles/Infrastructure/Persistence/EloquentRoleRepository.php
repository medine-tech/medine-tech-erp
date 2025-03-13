<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Security\Roles\Infrastructure\Persistence;

use Closure;
use Exception;
use Illuminate\Support\Facades\DB;
use MedineTech\Backoffice\Security\Roles\Domain\RoleRepository;
use MedineTech\Backoffice\Security\Roles\Domain\Role;
use RuntimeException;
use function Lambdish\Phunctional\map;

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

    public function find(int $id): ?Role
    {
        $model = RoleModel::find($id);

        if (!$model) {
            return null;
        }

//        $roleData = $model->toArray();
//        $roleData['password'] = $model->password;

        $fromDatabase = $this->fromDatabase();
        return $fromDatabase($model);
    }

    public function search(array $filters, int $perPage = 20): array
    {
        $paginator = RoleModel::fromFilters($filters)
            ->paginate($perPage);

        return [
            'items' => map($this->fromDatabase(), $paginator->items()),
            'total' => $paginator->total(),
            'perPage' => $paginator->perPage(),
            'currentPage' => $paginator->currentPage(),
        ];
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


    private function fromDatabase(): Closure
    {
        return fn(RoleModel $model) => Role::fromPrimitives([
            'id' => $model['id'],
            'code' => $model['code'],
            'name' => $model['name'],
            'description' => $model['description'],
            'status' => $model['status'],
            'creatorId' => $model['creator_id'],
            'updaterId' => $model['updater_id'],
            'companyId' => $model['company_id'],
        ]);
    }
}
