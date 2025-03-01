<?php

declare(strict_types=1);

namespace MedineTech\Users\Domain;

interface UserRepository
{
    public function save(User $user): void;

    public function findByEmail(UserEmail $email): ?User;

    public function nextId(): int;

    public function find(int $id): ?User;

}
