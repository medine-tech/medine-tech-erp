<?php
declare(strict_types=1);

namespace MedineTech\Backoffice\Accounting\AccountingCenter\Application\Search;

final class AccountingCentersSearcherResponse
{
    /** @var array<int, mixed> */
    private array $items;
    private int $total;
    private int $perPage;
    private int $currentPage;

    /**
     * @param array<int, mixed> $items
     */
    public function __construct(array $items, int $total, int $perPage, int $currentPage)
    {
        $this->items       = $items;
        $this->total       = $total;
        $this->perPage     = $perPage;
        $this->currentPage = $currentPage;
    }

    /**
     * @return array<int, mixed>
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
