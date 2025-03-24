<?php

namespace MedineTech\Auth\Companies\Infrastructure\Persistence\Eloquent;

use Closure;
use MedineTech\Auth\Companies\Domain\AuthCompany;
use MedineTech\Auth\Companies\Domain\AuthCompanyRepository;
use MedineTech\Backoffice\Companies\Infrastructure\Persistence\Eloquent\CompanyModel;
use function Lambdish\Phunctional\map;

final class EloquentAuthCompanyRepository implements AuthCompanyRepository
{
    public function search(array $filters): array
    {
        $paginator = CompanyModel::fromFilters($filters)
            ->paginate(20);

        return [
            'items' => map($this->fromDatabase(), $paginator->items()),
            'total' => $paginator->total(),
            'perPage' => $paginator->perPage(),
            'currentPage' => $paginator->currentPage(),
        ];
    }

    private function fromDatabase(): Closure
    {
        return function (CompanyModel $model) {
            return new AuthCompany(
                $model->id,
                $model->data['name'] ?? "without name"
            );
        };
    }
}
