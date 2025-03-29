<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Companies\Application\Search;

final readonly class CompaniesSearcherResponse
{
    /**
     * @param array<int, array<string, mixed>> $items
     * @param int $total
     * @param int $perPage
     * @param int $currentPage
     */
    public function __construct(
        private array $items,
        private int $total,
        private int $perPage,
        private int $currentPage,
    ) {
    }

    /**
     * @return array<int, array<string, mixed>>
     */
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
