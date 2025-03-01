<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Users\Infrastructure\Persistence\Eloquent;

use App\Models\User as UserModel;
use Closure;
use MedineTech\Backoffice\Users\Domain\User;
use MedineTech\Backoffice\Users\Domain\UserRepository;

final class EloquentUserRepository implements UserRepository
{
    public function save(User $user): void
    {
        $userModel = new UserModel();
        $userModel->name = $user->name();
        $userModel->email = $user->email();
        $userModel->password = $user->password();

        $userModel->save();

    }

    public function nextId(): int
    {
        $maxId = UserModel::max('id');
        return $maxId ? $maxId + 1 : 1;
    }

    public function findByEmail(string $email): ?User
    {
        $result = UserModel::where('email', $email)
            ->get()
            ->toArray();

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
        return fn(array $user) => User::fromPrimitive([
            'id' => $user['id'],
            'name' => $user["name"],
            'email' => $user["email"],
            'password' => $user["password"] ?? "",
        ]);
    }
}
