<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Users\Application\Search;

final class UsersSearcherResponse
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
