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
            $data = [
                'id' => $company->id(),
                'name' => $company->name()
            ];

            CompanyModel::updateOrCreate(
                ['id' => $company->id()],
                $data
            );

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
        $paginator = CompanyModel::fromFilters($filters)
            ->paginate($perPage);

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
            return Company::fromPrimitives([
                "id" => $model['id'],
                "name" => $model["name"] ?? "without name",
            ]);
        };
    }
}
