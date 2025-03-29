<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backoffice\Companies;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use MedineTech\Backoffice\Companies\Application\Search\CompaniesSearcher;
use MedineTech\Backoffice\Companies\Application\Search\CompaniesSearcherRequest;
use MedineTech\Backoffice\Companies\Application\Search\CompanySearcherResponse;
use MedineTech\Backoffice\Companies\Infrastructure\Authorization\CompaniesPermissions;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;
use function Lambdish\Phunctional\map;

/**
 * @OA\Get(
 *     path="/api/backoffice/{tenant}/companies",
 *     tags={"Backoffice - Companies"},
 *     summary="Retrieve a list of companies",
 *     description="Returns a paginated list of companies for authorized users. Accepts optional query parameters for filtering.",
 *     security={ {"bearerAuth": {} } },
 *     @OA\Parameter(
 *         name="page",
 *         in="query",
 *         required=false,
 *         description="Page number for pagination",
 *         @OA\Schema(
 *             type="integer",
 *             example=1
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="per_page",
 *         in="query",
 *         required=false,
 *         description="Number of entries per page",
 *         @OA\Schema(
 *             type="integer",
 *             example=10
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of companies retrieved successfully",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="items",
 *                 type="array",
 *                 @OA\Items(
 *                     @OA\Property(property="id", type="string", format="uuid", example="123e4567-e89b-12d3-a456-426655440000"),
 *                     @OA\Property(property="name", type="string", example="MedineTech")
 *                 )
 *             ),
 *             @OA\Property(property="total", type="integer", example=100),
 *             @OA\Property(property="per_page", type="integer", example=10),
 *             @OA\Property(property="current_page", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             @OA\Property(property="title", type="string", example="Unauthorized"),
 *             @OA\Property(property="status", type="integer", example=403),
 *             @OA\Property(property="detail", type="string", example="You do not have permission to view this resource.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal Server Error",
 *         @OA\JsonContent(
 *             @OA\Property(property="title", type="string", example="Internal Server Error"),
 *             @OA\Property(property="status", type="integer", example=500),
 *             @OA\Property(property="detail", type="string", example="An unexpected error occurred")
 *         )
 *     )
 * )
 */
final class CompaniesGetController extends ApiController
{
    public function __construct(
        private readonly CompaniesSearcher $searcher
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        return $this->execute(function () use ($request) {
            $user = $request->user();

            if (!$user->can(CompaniesPermissions::VIEW)) {
                throw new UnauthorizedException(403);
            }

            $filters = (array)$request->query();
            $filters["userId"] = $user->id;
            $response = ($this->searcher)(new CompaniesSearcherRequest($filters));

            return new JsonResponse([
                'items' => map(function (CompanySearcherResponse $response) {
                    return [
                        'id' => $response->id(),
                        'name' => $response->name(),
                    ];
                }, $response->items()),
                'total' => $response->total(),
                'per_page' => $response->perPage(),
                'current_page' => $response->currentPage(),
            ], Response::HTTP_OK);
        });
    }

    protected function exceptions(): array
    {
        return [
            UnauthorizedException::class => Response::HTTP_FORBIDDEN,
        ];
    }
}
