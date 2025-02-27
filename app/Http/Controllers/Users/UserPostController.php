<?php
declare(strict_types=1);

namespace App\Http\Controllers\Users;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use MedineTech\Users\Application\Create\UserCreator;
use MedineTech\Users\Application\Create\UserCreatorRequest;

/**
 * @OA\Post(
 *     path="/API_Flexio/v1/users",
 *     summary="Create a new user",
 *     tags={"Users"},
 *     security={{"token":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"id", "name", "email", "password"},
 *             @OA\Property(property="id", type="string", example="user_123"),
 *             @OA\Property(property="name", type="string", example="John Doe"),
 *             @OA\Property(property="email", type="string", example="john@example.com"),
 *             @OA\Property(property="password", type="string", example="secret")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="User created successfully"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
final class UserPostController
{
    public function __construct(
        private UserCreator $creator
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'id'       => 'required|string',
                'name'     => 'required|string',
                'email'    => 'required|email',
                'password' => 'required|string'
            ]);

            ($this->creator)(new UserCreatorRequest($validatedData));

            return new JsonResponse(null, 201);
        } catch (Exception $e) {
            Log::error('User creation error: ' . $e->getMessage());

            return new JsonResponse([
                'title'  => 'Error',
                'status' => 500,
                'detail' => 'An error occurred'
            ], 500);
        }
    }
}
