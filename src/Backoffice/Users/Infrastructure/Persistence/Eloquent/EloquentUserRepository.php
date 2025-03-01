<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Users\Infrastructure\Persistence\Eloquent;

use App\Models\User as UserModel;
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
        $userModel = UserModel::where('email', $email)->first();

        if (!$userModel) {
            return null;
        }

        return User::fromPrimitive([
            'id' => $userModel->id,
            'name' => $userModel->name,
            'email' => $userModel->email,
            'password' => $userModel->password,
        ]);
    }
}
