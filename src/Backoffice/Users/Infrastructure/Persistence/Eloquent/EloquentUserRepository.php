<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Users\Infrastructure\Persistence\Eloquent;

use App\Models\User as UserModel;
use Closure;
use Illuminate\Database\QueryException;
use MedineTech\Backoffice\Users\Domain\User;
use MedineTech\Backoffice\Users\Domain\UserAlreadyExists;
use MedineTech\Backoffice\Users\Domain\UserRepository;

final class EloquentUserRepository implements UserRepository
{
    public function save(User $user): void
    {
        try {
            $model = UserModel::findOrFail($user->id());
            $data = $this->toDatabase($user->toPrimitives());

            if (!$this->isPasswordChanged($user) || $user->password() === null) {
                unset($data['password']);
            }

            $model->update($data);
        } catch (QueryException $e) {
            $this->handleDatabaseExceptions($e, $user->email());
        }
    }

    public function create(User $user): void
    {
        try {
            $data = $this->toDatabase($user->toPrimitives());

            UserModel::create($data);
        } catch (QueryException $e) {
            $this->handleDatabaseExceptions($e, $user->email());
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

    private function isPasswordChanged(User $user): bool
    {
        return method_exists($user, 'isPasswordChanged') ? $user->isPasswordChanged() : false;
    }

    private function handleDatabaseExceptions(QueryException $e, string $email): void
    {
        if (isset($e->errorInfo[1]) && $e->errorInfo[1] === 1062) {
            throw new UserAlreadyExists($email);
        }
        throw new \RuntimeException("Database error: " . $e->getMessage());
    }

    private function toDatabase(array $params): array
    {
        return array_combine(
            array_map(static fn($key) => \Illuminate\Support\Str::snake($key), array_keys($params)),
            array_values($params)
        );
    }

    private function fromDatabase(): Closure
    {
        return fn(array $user) => User::fromPrimitives([
            'id' => $user['id'],
            'name' => $user["name"],
            'email' => $user["email"],
            'password' => $user["password"] ?? "",
        ]);
    }
}
