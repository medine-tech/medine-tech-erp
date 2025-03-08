<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Users\Infrastructure\Persistence\Eloquent;

use App\Models\User as UserModel;
use Closure;
use Illuminate\Database\QueryException;
use MedineTech\Backoffice\Users\Domain\User;
use MedineTech\Backoffice\Users\Domain\UserRepository;

final class EloquentUserRepository implements UserRepository
{
    public function save(User $user): int
    {
        try {
            $model = UserModel::find($user->id());

            if ($model) {
                $model->name = $user->name();
                $model->save();

                return $model->id;
            }

            UserModel::create([
                'id' => $user->id(),
                'name' => $user->name(),
                'email' => $user->email(),
                'password' => $user->password(),
            ]);

            return $user->id();
        } catch (QueryException $e) {
            throw new $e;
        }
    }

    public function find(int $id): ?User
    {
        $model = UserModel::find($id);

        if (!$model) {
            return null;
        }

        $userData = $model->toArray();
        $userData['password'] = $model->password;

        $fromDatabase = $this->fromDatabase();
        return $fromDatabase($userData);
    }

    public function nextId(): int
    {
        return (UserModel::max('id') ?? 0) + 1;
    }

    public function findByEmail(string $email): ?User
    {
        $result = UserModel::where('email', $email)
            ->get();

        return $result
            ->map($this->fromDatabase())
            ->first();
    }

    public function search(array $filters): array
    {
        $result = UserModel::where($filters)
            ->paginate(20)
            ->toArray();

        return [
            'items' => array_map($this->fromDatabase(), $result['data']),
            'total' => $result['total'],
            'per_page' => $result['per_page'],
            'current_page' => $result['current_page'],
        ];
    }

    private function fromDatabase(): Closure
    {
        return fn(array $user) => User::fromPrimitives([
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'password' => $user['password'] ?? "",
        ]);
    }
}
