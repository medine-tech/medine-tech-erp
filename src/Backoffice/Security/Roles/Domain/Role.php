<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Security\Roles\Domain;

use MedineTech\Shared\Domain\Aggregate\AggregateRoot;

final class Role extends AggregateRoot
{
    public function __construct(
        private int $id,
        private string $code,
        private string $name,
        private ?string $description,
        private string $status,
        private int $creatorId,
        private int $updaterId,
        private string $companyId
    )
    {
    }

    public static function create(
        int $id,
        string $code,
        string $name,
        ?string $description,
        int $creatorId,
        string $companyId
    ): self
    {

        $status = RoleStatus::ACTIVE;
        $updaterId = $creatorId;

        $role = new self(
            $id,
            $code,
            $name,
            $description,
            $status,
            $creatorId,
            $updaterId,
            $companyId
        );

        $role->record(new RoleCreatedDomainEvent(
            (string)$role->id(),
            $role->code(),
            $role->name(),
            $role->description(),
            $role->status(),
            $role->creatorId(),
            $role->updaterId(),
            $role->companyId()
        ));

        return $role;
    }

    public static function fromPrimitives(array $primitives): self
    {
        return new self(
            (int)$primitives['id'],
            (string)$primitives['code'],
            (string)$primitives['name'],
            (string)$primitives['description'],
            (string)$primitives['status'],
            (int)$primitives['creatorId'],
            (int)$primitives['updaterId'],
            (string)$primitives['companyId']
        );
    }

    public function toPrimitives(): array
    {
        return [
            'id' => $this->id(),
            'code' => $this->code(),
            'name' => $this->name(),
            'description' => $this->description(),
            'status' => $this->status(),
            'creatorId' => $this->creatorId(),
            'updaterId' => $this->updaterId(),
            'companyId' => $this->companyId()
        ];
    }

    public function id(): int
    {
        return $this->id;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): ?string
    {
        return $this->description;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function creatorId(): int
    {
        return $this->creatorId;
    }

    public function updaterId(): int
    {
        return $this->updaterId;
    }

    public function companyId(): string
    {
        return $this->companyId;
    }
}
