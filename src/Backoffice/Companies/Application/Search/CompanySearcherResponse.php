<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Companies\Application\Search;

final class CompanySearcherResponse
{
    public function __construct(
        private array $items
    ) {
    }

    public function items(): array
    {
        return $this->items;
    }
}
