<?php

declare(strict_types=1);

namespace MedineTech\Users\Infrastructure\Persistence;

use App\Models\User as UserModel;
use MedineTech\Users\Domain\User;
use MedineTech\Users\Domain\UserRepository;

final class EloquentUserRepository implements UserRepository
{
    public function save(User $user): void
    {
        $userModel = new UserModel();
        $userModel->id = $user->id();
        $userModel->name = $user->name();
        $userModel->email = $user->email();
        $userModel->password = $user->password();

        $userModel->save();
    }
}
