<?php

declare(strict_types=1);

namespace MedineTech\Auth\Users\Domain;

interface AuthUserRepository
{
    public function find(int $id): ?AuthUser;

}
