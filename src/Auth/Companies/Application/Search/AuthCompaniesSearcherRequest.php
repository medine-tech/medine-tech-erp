<?php

declare(strict_types=1);

namespace MedineTech\Auth\Companies\Application\Search;

final class AuthCompaniesSearcherRequest
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
