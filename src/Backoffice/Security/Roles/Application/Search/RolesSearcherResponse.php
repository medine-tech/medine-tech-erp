<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Security\Roles\Application\Search;

final readonly class RolesSearcherResponse
{
    /**
     * @param array<int, RoleSearcherResponse> $items
     * @param int $total
     * @param int $perPage
     * @param int $currentPage
     */
    public function __construct(
        /** @var array<int, RoleSearcherResponse> */
        private array $items,
        private int $total,
        private int $perPage,
        private int $currentPage
    )
    {
    }

    /**
     * @return array<int, RoleSearcherResponse>
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
