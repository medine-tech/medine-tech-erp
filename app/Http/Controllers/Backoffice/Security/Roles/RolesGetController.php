<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backoffice\Security\Roles;

use Exception;
use Illuminate\Http\Request;
use MedineTech\Backoffice\Security\Roles\Application\Search\RolesSearcher;
use MedineTech\Backoffice\Security\Roles\Application\Search\RolesSearcherRequest;
use MedineTech\Backoffice\Security\Roles\Infrastructure\Authorization\RolesPermissions;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\JsonResponse;

final class RolesGetController
{
    public function __construct(
        private readonly RolesSearcher $searcher
    )
    {
    }

    public function __invoke(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
//            if (!$request->user()->can(RolesPermissions::VIEW)) {
//                throw new UnauthorizedException(403);
//            }

            $filters = (array)$request->query();
            $filters["company_id"] = $request->user()->id;

            $searcherRequest = new RolesSearcherRequest($filters);
            $searcherResponse = ($this->searcher)($searcherRequest);

            $roles = array_map(function ($role) {
                return [
                    "id" => $role->id(),
                    "code" => $role->code(),
                    "name" => $role->name(),
                    "description" => $role->description(),
                    "status" => $role->status(),
                    "creatorId" => $role->creatorId(),
                    "updaterId" => $role->updaterId(),
                    "companyId" => $role->companyId(),
                ];
            }, $searcherResponse->items());

            return response()->json([
                "items" => $roles,
                "total" => $searcherResponse->total(),
                "per_page" => $searcherResponse->perPage(),
                "current_page" => $searcherResponse->currentPage()
            ]);
        } catch (UnauthorizedException) {
            return response()->json([
                "title" => "Unauthorized",
                "status" => JsonResponse::HTTP_FORBIDDEN,
                "detail" => "You do not have permission to view this resource.",
            ], JsonResponse::HTTP_FORBIDDEN);
        } catch (Exception $e) {
            $detail = config('app.env') !== 'production' ? $e->getMessage() : "An unexpected error occurred";
            return response()->json([
                "title" => "Internal Server Error",
                "status" => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                "detail" => $detail,
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
