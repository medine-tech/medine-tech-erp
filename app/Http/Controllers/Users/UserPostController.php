<?php
declare(strict_types=1);

namespace App\Http\Controllers\Users;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use MedineTech\Users\Application\Create\UserCreator;
use MedineTech\Users\Application\Create\UserCreatorRequest;

/**
 * @OA\Post(
 *     path="/api/users",
 *     summary="Create a new user",
 *     tags={"Users"},
 *     security={{"token":{OA\Property(property="email", type="string", example="john@example.com"),
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
 *  @OA\Response(
 *          response=422,
 *          description="Business Rule Violation"
 *      ),
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
                'name'     => 'required|string|min:3|max:30',
                'email'    => 'required|email',
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
                'detail' => $e->getMessage(),
                'errors' => $e->errors(),
            ], 400);
        } catch (\DomainException $e) {
            Log::warning('Domain error during user creation: ' . $e->getMessage());
            return new JsonResponse([
                'title' => 'Business Rule Violation',
                'status' => 422,
                'detail' => $e->getMessage()
            ], 422);
        } catch (Exception $e) {
            Log::error('User creation error: ' . $e->getMessage());
            return new JsonResponse([
                'title' => 'Error',
                'status' => 500,
                'detail' => app()->environment('production') ? 'An error occurred' : $e->getMessage()
            ], 500);
        }
    }
}
