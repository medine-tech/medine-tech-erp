<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth\Users;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use MedineTech\Auth\Users\Application\Search\AuthUserSearcherResponse;
use MedineTech\Auth\Users\Application\Search\AuthUsersSearcher;
use MedineTech\Auth\Users\Application\Search\AuthUsersSearcherRequest;
use MedineTech\Auth\Users\Infrastructure\Authorization\AuthUsersPermissions;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;
use function Lambdish\Phunctional\map;

/**
 * @OA\Get(
 *     path="/api/auth/users",
 *     summary="Get list of authenticated users",
 *     tags={"Auth - Users"},
 *     security={
 *         {"bearerAuth": {}}
 *     },
 *     @OA\Parameter(
 *         name="page",
 *         in="query",
 *         description="Page number for pagination",
 *         required=false,
 *         @OA\Schema(
 *             type="integer",
 *             minimum=1
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successfully retrieved user list",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="items", type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="string", example="f7c5bdb2-1f8e-4f19-9c6d-f8c4a4d54a9a"),
 *                     @OA\Property(property="name", type="string", example="John Doe"),
 *                     @OA\Property(property="email", type="string", example="john@example.com"),
 *                     @OA\Property(property="default_company_id", type="string", example="a1b2c3d4-e5f6-g7h8-i9j0-k1l2m3n4o5p6")
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
 *             type="object",
 *             @OA\Property(property="title", type="string", example="Internal Server Error"),
 *             @OA\Property(property="detail", type="string", example="An unexpected error occurred"),
 *             @OA\Property(property="status", type="integer", example=500)
 *         )
 *     )
 * )
 */
final class AuthUsersGetController extends ApiController
{
    public function __construct(
        private readonly AuthUsersSearcher $searcher
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        return $this->execute(function () use ($request) {
            $user = $request->user();

//            if (!$user->can(AuthUsersPermissions::VIEW)) {
//                throw new UnauthorizedException(403);
//            }

            $filters = (array)$request->query();
            $filters["userId"] = $user->id;
            $response = ($this->searcher)(new AuthUsersSearcherRequest($filters));

            return new JsonResponse([
                'items' => map(function (AuthUserSearcherResponse $response) {
                    return [
                        'id' => $response->id(),
                        'name' => $response->name(),
                        'email' => $response->email(),
                        'default_company_id' => $response->defaultCompanyId(),
                    ];
                }, $response->items()),
                'total' => $response->total(),
                'per_page' => $response->perPage(),
                'current_page' => $response->currentPage(),
            ], Response::HTTP_OK);
        });
    }
}
