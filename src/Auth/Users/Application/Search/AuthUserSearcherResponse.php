<?php

declare(strict_types=1);

namespace MedineTech\Auth\Users\Application\Search;

final readonly class AuthUserSearcherResponse
{
    public function __construct(
        private string $id,
        private string $name,
        private string $email,
        private string $defaultCompanyId
    ) {
    }

    public static function fromPrimitives(array $row): self
    {
        return new self(
            (string)$row['id'],
            (string)$row['name'],
            (string)$row['email'],
            (string)$row['default_company_id']
        );
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function defaultCompanyId(): string
    {
        return $this->defaultCompanyId;
    }
}
