<?php

declare(strict_types=1);

namespace MedineTech\Auth\Companies\Application\Search;

final readonly class AuthCompaniesSearcherResponse
{
    public function __construct(
        private array $items,
        private int $total,
        private int $perPage,
        private int $currentPage,
    ) {
    }

    public function items(): array
    {
        return $this->items;
    }

    public function total(): int
    {
        return $this->total;
    }

    public function perPage(): int
    {
        return $this->perPage;
    }

    public function currentPage(): int
    {
        return $this->currentPage;
    }
}
