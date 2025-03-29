<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Companies\Application\Search;

final readonly class CompaniesSearcherRequest
{
    /**
     * @param array<string, mixed> $filters
     */
    public function __construct(
        private array $filters,
        private int $perPage
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function filters(): array
    {
        return $this->filters;
    }

    public function perPage(): int
    {
        return $this->perPage;
    }
}
