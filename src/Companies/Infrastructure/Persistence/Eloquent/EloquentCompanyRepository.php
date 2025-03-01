<?php

namespace MedineTech\Companies\Infrastructure\Persistence\Eloquent;

use Illuminate\Support\Str;
use MedineTech\Companies\Domain\Company;
use MedineTech\Companies\Domain\CompanyRepository;

final class EloquentCompanyRepository implements CompanyRepository
{

    public function save(Company $company): void
    {
        try {
            $model = CompanyModel::find($company->id());

            if ($model) {
                $model->name = $company->name();
                $model->save();
            } else {
                $companyModel = new CompanyModel();
                $companyModel->id = $company->id();
                $companyModel->name = $company->name();
                $companyModel->save();
            }
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to save company: " . $e->getMessage(), 0, $e);
        }
    }

    public function find(string $id): ?Company
    {
        $model = CompanyModel::query()
            ->where('id', $id)
            ->first();

        if (!$model) {
            return null;
        }

        $params = $this->fromDatabase($model->toArray());
        return Company::fromPrimitives($params);
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
