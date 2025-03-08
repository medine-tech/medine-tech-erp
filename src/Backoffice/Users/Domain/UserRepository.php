<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Users\Domain;

interface UserRepository
{
    public function save(User $user): int;

    public function find(int $id): ?User;

    public function findByEmail(string $email): ?User;

    public function nextId(): int;

    public function search(array $filters): array;

}
