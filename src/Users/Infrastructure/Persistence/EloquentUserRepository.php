<?php
declare(strict_types=1);

namespace MedineTech\Users\Infrastructure\Persistence;

use App\Models\User as UserModel;
use Illuminate\Database\QueryException;
use MedineTech\Users\Domain\User;
use MedineTech\Users\Domain\UserRepository;
use MedineTech\Users\Domain\UserEmail;
use MedineTech\Users\Domain\UserAlreadyExists;

final class EloquentUserRepository implements UserRepository
{
    public function nextId(): int
    {
        return (UserModel::max('id') ?? 0) + 1;
    }

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
            UserModel::create($this->toDatabase($user->toPrimitives()));
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

    return User::fromPrimitives($this->fromDatabase($userData));
}

    public function findByEmail(UserEmail $email): ?User
    {
        $model = UserModel::where('email', $email->value())->first();

        if (!$model) {
            return null;
        }

        $userData = $model->toArray();
        $userData['password'] = $model->password;

        return User::fromPrimitives($this->fromDatabase($userData));
    }

    private function handleDatabaseExceptions(QueryException $e, string $email): void
    {
        if ($e->errorInfo === 1062) {
            throw new UserAlreadyExists($email);
        }
        throw new \RuntimeException("Database error: " . $e->getMessage());
    }

    private function fromDatabase(array $params): array
    {
        return array_combine(
            array_map(static fn($key) => \Illuminate\Support\Str::camel($key),
                array_keys($params)
            ), array_values($params));
    }

    private function toDatabase(array $params): array
    {
        return array_combine(
            array_map(static fn($key) => \Illuminate\Support\Str::snake($key),
                array_keys($params)
            ), array_values($params));
    }

    private function isPasswordChanged(User $user): bool
    {
        return $user instanceof User && method_exists($user, 'isPasswordChanged')
            ? $user->isPasswordChanged()
            : false;
    }
}
