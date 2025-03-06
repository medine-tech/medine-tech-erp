<?php
declare(strict_types=1);

namespace App\Http\Controllers\Users;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use MedineTech\Users\Application\Create\UserCreator;
use MedineTech\Users\Application\Create\UserCreatorRequest;
use MedineTech\Users\Domain\UserAlreadyExists;

/**
 * @OA\Post(
 *     path="/users",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "email", "password"},
 *             @OA\Property(property="name", type="string", example="John Doe"),
 *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
 *             @OA\Property(property="password", type="string", example="secret")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="User created successfully"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Validation error"
 *     ),
 *     @OA\Response(
 *         response=409,
 *         description="Conflict: User already exists"
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
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|min:3|max:30',
                'email' => 'required|email',
                'password' => 'required|string|min:8|max:30'
            ]);

            ($this->creator)(
                new UserCreatorRequest(
                    $validatedData['name'],
                    $validatedData['email'],
                    $validatedData['password']
                )
            );

            return new JsonResponse(null, JsonResponse::HTTP_CREATED);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return new JsonResponse([
                'title' => 'Validation Error',
                'status' => JsonResponse::HTTP_BAD_REQUEST,
                'detail' => $e->getMessage(),
                'errors' => $e->errors()
            ], JsonResponse::HTTP_BAD_REQUEST);

        } catch (UserAlreadyExists $e) {
            Log::warning('Conflict: ' . $e->getMessage());
            return new JsonResponse([
                'title' => 'Conflict',
                'status' => JsonResponse::HTTP_CONFLICT,
                'detail' => $e->getMessage()
            ], JsonResponse::HTTP_CONFLICT);

        } catch (Exception $e) {
            Log::error('Server error: ' . $e->getMessage());
            return new JsonResponse([
                'title' => 'Internal Server Error',
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'detail' => 'Error interno del servidor'
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
