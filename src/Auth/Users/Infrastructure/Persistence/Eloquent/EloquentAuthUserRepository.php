<?php

namespace MedineTech\Auth\Users\Infrastructure\Persistence\Eloquent;

use App\Models\User;
use Closure;
use MedineTech\Auth\Users\Domain\AuthUser;
use MedineTech\Auth\Users\Domain\AuthUserRepository;
use function Lambdish\Phunctional\map;

final class EloquentAuthUserRepository implements AuthUserRepository
{
    public function find(int $id): ?AuthUser
    {
        $model = User::find($id);

        if (!$model) {
            return null;
        }

        $fromDatabase = $this->fromDatabase();
        return $fromDatabase($model);
    }

    private function fromDatabase(): Closure
    {
        return function (User $model) {
            return new AuthUser(
                $model->id,
                $model->name ?? "without name",
                $model->email,
                $model->default_company_id ?? ''
            );
        };
    }
}
