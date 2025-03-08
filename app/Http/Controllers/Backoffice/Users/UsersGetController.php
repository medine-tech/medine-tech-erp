<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backoffice\Users;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use MedineTech\Backoffice\Users\Application\Search\UsersSearcher;
use MedineTech\Backoffice\Users\Application\Search\UsersSearcherRequest;

/**
 * @OA\Get(
 *     path="/api/backoffice/users",
 *     summary="Search users based on filters",
 *     tags={"Backoffice - Users"},
 *     @OA\Parameter(name="page",in="query",description="Page number for pagination",required=false,
 *         @OA\Schema(type="integer",minimum=1
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful retrieval of user list",
 *         @OA\JsonContent(type="object",
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Success"),
 *             @OA\Property(property="data",type="object",
 *                 @OA\Property(property="users",type="array",
 *                     @OA\Items(type="object",
 *                         @OA\Property(property="id", type="integer", example=1),
 *                         @OA\Property(property="name", type="string", example="John Doe"),
 *                         @OA\Property(property="email", type="string", example="john@example.com")
 *                     )
 *                 ),
 *                 @OA\Property(property="total", type="integer", example=100),
 *                 @OA\Property(property="current_page", type="integer", example=1)
 *             )
 *         )
 *     ),
 *     @OA\Response(response=500,description="Internal Server Error",
 *         @OA\JsonContent(type="object",
 *             @OA\Property(property="status", type="integer", example=500),
 *             @OA\Property(property="message", type="string", example="An error occurred"),
 *             @OA\Property(property="data",type="object",
 *             @OA\Property(property="users", type="array", @OA\Items(type="object"))
 *             )
 *         )
 *     )
 * )
 */
final class UsersGetController extends Controller
{
    public function __construct(
        private UsersSearcher $searcher
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'page' => 'sometimes|integer|min:1',
        ]);

        try {
            $filters = $request->query();
            $searchRequest = new UsersSearcherRequest($filters);
            $searchResponse = ($this->searcher)($searchRequest);

            $users = array_map(function($user) {
                return [
                    'id'    => $user->id(),
                    'name'  => $user->name(),
                    'email' => $user->email(),
                ];
            }, $searchResponse->items());

            return response()->json([
                'status'       => 200,
                'message'      => 'Success',
                'data'         => [
                    'users'        => $users,
                    'total'        => $searchResponse->total(),
                    'per_page'     => $searchResponse->perPage(),
                    'current_page' => $searchResponse->currentPage(),
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 500,
                'message' => 'An error occurred',
                'data'    => [
                    'users' => [],
                ],
            ], 500);
        }
    }
}
