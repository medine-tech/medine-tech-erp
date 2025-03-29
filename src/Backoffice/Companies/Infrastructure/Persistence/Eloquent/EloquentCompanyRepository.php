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
                $model['name'] = $company->name();
                $model->save();
            } else {
                $companyModel = new CompanyModel();
                $companyModel->id = $company->id();
                $companyModel['name'] = $company->name();
                $companyModel->save();
            }
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to save company: " . $e->getMessage(), 0, $e);
        }
    }

    public function find(string $id): ?Company
    {
        $model = CompanyModel::where('id', $id)->first();

        if (null === $model) {
            return null;
        }

        $fromDatabase = $this->fromDatabase();
        return $fromDatabase($model);
    }

    /**
     * @param array<string, mixed> $filters
     * @param int $perPage
     * @return array{items: array<int, Company>, total: int, perPage: int, currentPage: int}
     */
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

    /**
     * @return Closure(CompanyModel): Company
     */
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
