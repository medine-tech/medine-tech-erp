<?php

declare(strict_types=1);

namespace MedineTech\Auth\Users\Domain;

interface AuthUserRepository
{
    public function find(string $id): ?AuthUser;
    public function search(array $filters): array;


}
