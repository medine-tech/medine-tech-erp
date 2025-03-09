<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backoffice\Companies;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use MedineTech\Backoffice\Companies\Application\Search\CompaniesSearcher;
use MedineTech\Backoffice\Companies\Application\Search\CompaniesSearcherRequest;
use MedineTech\Backoffice\Companies\Application\Search\CompanySearcherResponse;
use MedineTech\Backoffice\Companies\Infrastructure\Authorization\CompaniesPermissions;
use Spatie\Permission\Exceptions\UnauthorizedException;
use function Lambdish\Phunctional\map;

final class CompaniesGetController extends Controller
{
    public function __construct(
        private readonly CompaniesSearcher $searcher
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
//            Role::create(['name' => 'developer']);
//            Permission::create(['name' => CompanyPermissions::VIEW]);
//
//            $role = Role::findByName('developer');
//            $permission = Permission::findByName(CompanyPermissions::VIEW->value);
//            $role->syncPermissions([$permission]);
//            $user->syncRoles([$role->name]);

            if (!$user->can(CompaniesPermissions::VIEW)) {
                throw new UnauthorizedException(403);
            }

            $filters = (array)$request->query();
            $filters["userId"] = $user->id;
            $response = ($this->searcher)(new CompaniesSearcherRequest($filters));

            return response()->json([
                'items' => map(function (CompanySearcherResponse $response) {
                    return [
                        'id' => $response->id(),
                        'name' => $response->name(),
                    ];
                }, $response->items()),
                'total' => $response->total(),
                'per_page' => $response->perPage(),
                'current_page' => $response->currentPage(),
            ]);
        } catch (UnauthorizedException) {
            return response()->json([
                "title" => "Unauthorized",
                "detail" => "You do not have permission to view this resource.",
                "status" => 403,
            ], 403);
        } catch (Exception $e) {
            $detail = config('app.env') !== 'production' ? $e->getMessage() : "An unexpected error occurred";
            return response()->json([
                "title" => "Internal Server Error",
                "detail" => $detail,
                "status" => 500,
            ], 500);
        }
    }
}
