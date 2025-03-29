<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Security\Roles\Application\Search;

final class RolesSearcherRequest
{
    /** @var array<string, mixed> */
    private array $filters;

    /**
     * @param array<string, mixed> $filters
     */
    public function __construct(
        array $filters,
    )
    {
        $this->filters = $filters;
    }

    /**
     * @return array<string, mixed>
     */
    public function filters(): array
    {
        return $this->filters;
    }
}
