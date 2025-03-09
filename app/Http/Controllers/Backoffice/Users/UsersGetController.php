<?php
declare(strict_types=1);

namespace App\Http\Controllers\Backoffice\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use MedineTech\Backoffice\Users\Application\Search\UsersSearcher;
use MedineTech\Backoffice\Users\Application\Search\UsersSearcherRequest;
use MedineTech\Backoffice\Users\Infrastructure\Authorization\UsersPermissions;
use Spatie\Permission\Exceptions\UnauthorizedException;

/**
 * @OA\Get(
 *     path="/api/backoffice/users",
 *     summary="Search users based on filters",
 *     tags={"Backoffice - Users"},
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
 *         description="Successful retrieval of user list",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="items", type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="name", type="string", example="John Doe"),
 *                     @OA\Property(property="email", type="string", example="john@example.com")
 *                 )
 *             ),
 *             @OA\Property(property="total", type="integer", example=100),
 *             @OA\Property(property="per_page", type="integer", example=10),
 *             @OA\Property(property="current_page", type="integer", example=1)
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
final class UsersGetController extends Controller
{
    public function __construct(
        private UsersSearcher $searcher
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            if (!$request->user()->can(UsersPermissions::VIEW)) {
                throw new UnauthorizedException(403);
            }

            $filters = (array)$request->query();
            $filters["companyId"] = tenant("id");

            $searchRequest = new UsersSearcherRequest($filters);
            $searchResponse = ($this->searcher)($searchRequest);

            $users = array_map(function ($user) {
                return [
                    'id' => $user->id(),
                    'name' => $user->name(),
                    'email' => $user->email(),
                ];
            }, $searchResponse->items());

            return response()->json([
                'items' => $users,
                'total' => $searchResponse->total(),
                'per_page' => $searchResponse->perPage(),
                'current_page' => $searchResponse->currentPage(),
            ]);
        } catch (UnauthorizedException) {
            return response()->json([
                "title" => "Unauthorized",
                "detail" => "You do not have permission to view this resource.",
                "status" => 403,
            ], 403);
        } catch (\Exception $e) {
            return response()->json([
                "title" => "Internal Server Error",
                "detail" => "An unexpected error occurred",
                "error" => $e->getMessage(),
                "status" => 500,
            ], 500);
        }
    }
}
