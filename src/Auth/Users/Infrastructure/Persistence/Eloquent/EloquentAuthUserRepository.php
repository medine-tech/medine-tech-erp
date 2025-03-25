<?php

namespace MedineTech\Auth\Users\Infrastructure\Persistence\Eloquent;

use App\Models\User;
use Closure;
use MedineTech\Auth\Users\Domain\AuthUser;
use MedineTech\Auth\Users\Domain\AuthUserRepository;
use function Lambdish\Phunctional\map;

final class EloquentAuthUserRepository implements AuthUserRepository
{
    public function search(array $filters): array
    {
        $paginator = User::fromFilters($filters)
            ->paginate(20);

        return [
            'items' => map($this->fromDatabase(), $paginator->items()),
            'total' => $paginator->total(),
            'perPage' => $paginator->perPage(),
            'currentPage' => $paginator->currentPage(),
        ];
    }

    private function fromDatabase(): Closure
    {
        return function (User $model) {
            return new AuthUser(
                $model->id,
                $model->name ?? "without name",
                $model->email,
                $model->password,
                $model->default_company_id ?? ''
            );
        };
    }
}
