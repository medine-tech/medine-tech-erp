<?php

declare(strict_types=1);

namespace MedineTech\Backoffice\Users\Infrastructure\Persistence\Eloquent;

use App\Models\User as UserModel;
use Closure;
use MedineTech\Backoffice\Users\Domain\User;
use MedineTech\Backoffice\Users\Domain\UserRepository;
use RuntimeException;
use function Lambdish\Phunctional\map;

final class EloquentUserRepository implements UserRepository
{
    public function save(User $user): int
    {
        $model = UserModel::where([
            "email" => $user->email()
        ])->first();

        if ($model) {
            $model->name = $user->name();
            $model->save();

            return $model->id;
        }

        try {
             UserModel::create([
                'id' => $user->id(),
                'name' => $user->name(),
                'email' => $user->email(),
                'password' => $user->password(),
                'default_company_id' => $user->defaultCompanyId(),
            ]);
        } catch (\Exception $e) {
            throw new RuntimeException("Failed to save user: " . $e->getMessage(), 0, $e);
        }

        return $user->id();
    }

    public function find(int $id): ?User
    {
        $model = UserModel::find($id);

        if (!$model) {
            return null;
        }

        $userData = $model->toArray();
        $userData['password'] = $model->password;

        $fromDatabase = $this->fromDatabase();
        return $fromDatabase($userData);
    }

    public function nextId(): int
    {
        return (UserModel::max('id') ?? 0) + 1;
    }

    public function findByEmail(string $email): ?User
    {
        $result = UserModel::where('email', $email)
            ->get();

        return $result
            ->map($this->fromDatabase())
            ->first();
    }

    public function search(array $filters): array
    {
        $paginator = UserModel::fromFilters($filters)
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
        return fn(array $user) => User::fromPrimitives([
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'password' => $user['password'] ?? "",
            "defaultCompanyId" => $user['default_company_id'] ?? "",
        ]);
    }
}
