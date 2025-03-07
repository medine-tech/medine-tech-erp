<?php
declare(strict_types=1);

namespace MedineTech\Backoffice\Users\Application\Search;

final class UsersSearcherResponse
{
    private array $items;
    private int $total;
    private int $perPage;
    private int $currentPage;

    public function __construct(array $items, int $total, int $perPage, int $currentPage)
    {
        $this->items       = $items;
        $this->total       = $total;
        $this->perPage     = $perPage;
        $this->currentPage = $currentPage;
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
