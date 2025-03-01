<?php

namespace MedineTech\Companies\Infrastructure\Persistence\Eloquent;

use Illuminate\Support\Str;
use MedineTech\Companies\Domain\Company;
use MedineTech\Companies\Domain\CompanyRepository;

final class EloquentCompanyRepository implements CompanyRepository
{

    public function save(Company $company): void
    {
        $model = CompanyModel::find($company->id());
        $primitives = $this->toDatabase($company->toPrimitives());

        $model
            ? $model->update($primitives)
            : CompanyModel::create($primitives);
    }

    public function find(string $id): ?Company
    {
        return CompanyModel::query()
            ->where('id', $id)
            ->get()
            ->map(function (CompanyModel $model): Company {
                $params = $this->fromDatabase($model->toArray());
                return Company::fromPrimitives($params);
            })->first();
    }

    protected function fromDatabase(array $params): array
    {
        return array_combine(
            array_map(static fn($key) => Str::camel($key), array_keys($params)),
            array_values($params)
        );
    }

    protected function toDatabase(array $params): array
    {
        return array_combine(
            array_map(static fn($key) => Str::snake($key), array_keys($params)),
            array_values($params)
        );
    }
}
