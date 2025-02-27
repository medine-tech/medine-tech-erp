<?php

declare(strict_types=1);

namespace MedineTech\Users\Domain;

interface UserRepository
{
    public function save(User $user): void;

}
