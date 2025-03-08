<?php

namespace MedineTech\Backoffice\Companies\Infrastructure\Persistence\Eloquent;

use Closure;
use MedineTech\Backoffice\Companies\Domain\Company;
use MedineTech\Backoffice\Companies\Domain\CompanyRepository;
use function Lambdish\Phunctional\map;

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
        return CompanyModel::query()
            ->where('id', $id)
            ->get()
            ->map($this->fromDatabase())
            ->first();
    }

    public function search(array $filters, int $perPage = 20): array
    {
        $query = CompanyModel::fromFilters($filters);

        $result = $query
            ->paginate($perPage)
            ->toArray();

        return [
            'items' => map($this->fromDatabase(), $result['data']),
            'total' => $result['total'],
            'perPage' => $result['per_page'],
            'currentPage' => $result['current_page'],
        ];
    }

    private function fromDatabase(): Closure
    {
        return function (array $row) {
            return Company::fromPrimitives([
                "id" => $row['id'],
                "name" => $row["name"] ?? "without name",
            ]);
        };
    }
}
