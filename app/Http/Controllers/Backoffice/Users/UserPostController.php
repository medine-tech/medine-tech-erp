<?php
declare(strict_types=1);

namespace App\Http\Controllers\Backoffice\Users;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use MedineTech\Backoffice\Users\Application\Create\UserCreatorRequest;
use MedineTech\Backoffice\Users\Domain\UserAlreadyExists;
use MedineTech\Backoffice\Users\Application\Create\UserCreator;

/**
 * @OA\Post(
 *     path="/api/backoffice/users",
 *     tags={"Backoffice - Users"},
 *     summary="Create a new user",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name","email","password"},
 *             @OA\Property(property="name", type="string", example="John Doe"),
 *             ),@OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
 *             ), @OA\Property(property="password", type="string", example="secretPassword123"),
 *             )
 *         )
 *     ),
 *     @OA\Response(response=201,description="User created successfully"
 *     ),
 *     @OA\Response(response=400,description="Validation error",
 *         @OA\JsonContent(
 *             @OA\Property(property="title", type="string", example="Validation Error"),
 *             @OA\Property(property="status", type="integer", example=400),
 *             @OA\Property(property="detail", type="string", example="The given data was invalid."),
 *             @OA\Property(property="errors", type="object")
 *         )
 *     ), @OA\Response(response=500,description="Internal server error",
 *         @OA\JsonContent(
 *             @OA\Property(property="title", type="string", example="Internal Server Error"),
 *             @OA\Property(property="status", type="integer", example=500),
 *             @OA\Property(property="detail", type="string", example="An unexpected error occurred while processing your request.")
 *         )
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
                'detail' => 'The given data was invalid.',
                'errors' => $e->errors()
            ], JsonResponse::HTTP_BAD_REQUEST);

        } catch (Exception $e) {
            Log::error('Server error: ' . $e->getMessage());
            return new JsonResponse([
                'title' => 'Internal Server Error',
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'detail' => 'An unexpected error occurred'
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
