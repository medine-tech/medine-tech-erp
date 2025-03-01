<?php
declare(strict_types=1);

namespace App\Http\Controllers\Users;

use DomainException;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use MedineTech\Users\Application\Update\UserUpdater;
use MedineTech\Users\Application\Update\UserUpdaterRequest;

/**
 * @OA\Put(
 *     path="/api/users",
 *     summary="Update an existing user",
 *     tags={"Users"},
 *     security={{"token": {
 *          @OA\Property(property="email", type="string", example="john@example.com"),
 *          @OA\Property(property="password", type="string", example="secret")
 *     }}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"id", "name", "email", "password"},
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="name", type="string", example="Updated Name"),
 *             @OA\Property(property="email", type="string", format="email", example="updated@example.com"),
 *             @OA\Property(property="password", type="string", example="new_secret")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User updated successfully"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Business Rule Violation"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
final class UserPutController
{
    public function __construct(
        private UserUpdater $updater
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'id'       => 'required|integer',
                'name'     => 'required|string|min:3|max:30',
                'email'    => 'required|email',
                'password' => 'required|string|min:8|max:30'
            ]);

            $hashedPassword = Hash::make($validatedData['password']);

            ($this->updater)(
                new UserUpdaterRequest(
                    (int) $validatedData['id'],
                    $validatedData['name'],
                    $validatedData['email'],
                    $hashedPassword
                )
            );

            return new JsonResponse(null, 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return new JsonResponse([
                'title'  => 'Validation Error',
                'status' => 400,
                'detail' => 'The given data was invalid.',
                'errors' => $e->errors(),
            ], 400);
        } catch (DomainException $e) {
            Log::warning('Domain error during user update: ' . $e->getMessage());
            return new JsonResponse([
                'title'  => 'Business Rule Violation',
                'status' => 422,
                'detail' => 'A business rule was violated.',
            ], 422);
        } catch (Exception $e) {
            Log::error('User update error: ' . $e->getMessage());
            return new JsonResponse([
                'title'  => 'Error',
                'status' => 500,
                'detail' => 'An unexpected error occurred during user update.'
            ], 500);
        }
    }
}
