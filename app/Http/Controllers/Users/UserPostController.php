<?php
declare(strict_types=1);

namespace App\Http\Controllers\Users;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use MedineTech\Backoffice\Users\Application\Create\UserCreator;
use MedineTech\Backoffice\Users\Application\Create\UserCreatorRequest;

/**
 * @OA\Post(
 *     path="/api/users",
 *     summary="Create a new user",
 *     tags={"Users"},
 *     security={{"sanctum":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name","email","password"},
 *             @OA\Property(property="name", type="string", example="John Doe", description="User name (3-30 chars)"),
 *             @OA\Property(property="email", type="string", example="user@example.com", description="User email address"),
 *             @OA\Property(property="password", type="string", format="password", example="password123", description="User password (8-30 chars)")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="User created successfully"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Validation error",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="title", type="string", example="Validation Error"),
 *             @OA\Property(property="status", type="integer", example=400),
 *             @OA\Property(property="detail", type="string", example="The given data was invalid."),
 *             @OA\Property(property="errors", type="object")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Business Rule Violation",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="title", type="string", example="Business Rule Violation"),
 *             @OA\Property(property="status", type="integer", example=422),
 *             @OA\Property(property="detail", type="string", example="A business rule was violated.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="title", type="string", example="Error"),
 *             @OA\Property(property="status", type="integer", example=500),
 *             @OA\Property(property="detail", type="string", example="An unexpected error occurred during user creation.")
 *         )
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
                'name' => 'required|string|min:3|max:30',
                'email' => 'required|email',
                'password' => 'required|string|min:8|max:30'
            ]);

            $hashedPassword = Hash::make($validatedData['password']);

            ($this->creator)(
                new UserCreatorRequest(
                    $validatedData['name'],
                    $validatedData['email'],
                    $hashedPassword
                )
            );

            return new JsonResponse(null, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return new JsonResponse([
                'title' => 'Validation Error',
                'status' => 400,
                'detail' => 'The given data was invalid.',
                'errors' => $e->errors(),
            ], 400);
        } catch (\DomainException $e) {
            Log::warning('Domain error during user creation: ' . $e->getMessage());
            return new JsonResponse([
                'title' => 'Business Rule Violation',
                'status' => 422,
                'detail' => 'A business rule was violated.'
            ], 422);
        } catch (Exception $e) {
            Log::error('User creation error: ' . $e->getMessage());
            return new JsonResponse([
                'title' => 'Error',
                'status' => 500,
                'detail' => 'An unexpected error occurred during user creation.'
            ], 500);
        }
    }
}
