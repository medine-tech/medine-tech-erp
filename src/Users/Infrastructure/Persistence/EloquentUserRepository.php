<?php
declare(strict_types=1);

namespace MedineTech\Users\Infrastructure\Persistence;

use App\Models\User as UserModel;
use MedineTech\Users\Domain\User;
use MedineTech\Users\Domain\UserEmail;
use MedineTech\Users\Domain\UserRepository;

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

    public function findByEmail(UserEmail $email): ?User
    {
        $userModel = UserModel::where('email', $email->value())->first();
        if (!$userModel) {
            return null;
        }
        return User::fromPrimitive([
            'id'       => $userModel->id,
            'name'     => $userModel->name,
            'email'    => $userModel->email,
            'password' => $userModel->password,
        ]);
    }

    public function find(int $id): ?User
    {
        $userModel = UserModel::find($id);
        if (!$userModel) {
            return null;
        }
        return User::fromPrimitive([
            'id'       => $userModel->id,
            'name'     => $userModel->name,
            'email'    => $userModel->email,
            'password' => $userModel->password,
        ]);
    }
}
