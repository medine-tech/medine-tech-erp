<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Companies\Application\Search;

final class CompaniesSearcherResponse
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
