<?php

declare(strict_types=1);

namespace MedineTech\Auth\Users\Application\Search;

final class AuthUsersSearcherRequest
{
    private array $filters;

    public function __construct(
        array $filters
    ) {
        $this->filters = $filters;
    }

    public function filters(): array
    {
        return $this->filters;
    }
}
