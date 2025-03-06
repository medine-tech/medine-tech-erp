<?php
declare(strict_types=1);

namespace App\Http\Controllers\Users;

use App\Models\User;
use DomainException;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use MedineTech\Users\Application\Update\UserUpdater;
use MedineTech\Users\Application\Update\UserUpdaterRequest;

/**
 * @OA\Put(
 *     path="/users/{id}",
 *     tags={"Users"},
 *     summary="Update an existing user",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true, *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "email"},
 *             @OA\Property(property="name", type="string", example="New User Name"),
 *             @OA\Property(property="email", type="string", format="email", example="newuser@example.com"),
 *             @OA\Property(property="password", type="string", example="newpassword", nullable=true)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User updated successfully"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Validation error"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User not found"
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Domain error"
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

    public function __invoke(int $id, Request $request): JsonResponse
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return new JsonResponse([
                    'title' => 'User Not Found',
                    'status' => JsonResponse::HTTP_NOT_FOUND,
                    'detail' => "User with ID {$id} does not exist"
                ], JsonResponse::HTTP_NOT_FOUND);
            }

            $validationRules = [
                'name' => 'required|string|min:3|max:30',
                'email' => 'required|email'
            ];

            if ($request->has('password') && !empty($request->password)) {
                $validationRules['password'] = 'string|min:8|max:30';
            }

            $validatedData = $request->validate($validationRules);

            ($this->updater)(
                new UserUpdaterRequest(
                    $id,
                    $validatedData['name'],
                    $validatedData['email'],
                    $request->has('password') ? $request->password : null
                )
            );

            return new JsonResponse(['message' => 'User updated successfully'], JsonResponse::HTTP_OK);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return new JsonResponse([
                'title' => 'Validation Error',
                'status' => JsonResponse::HTTP_BAD_REQUEST,
                'detail' => $e->getMessage(),
                'errors' => $e->errors()
            ], JsonResponse::HTTP_BAD_REQUEST);

        } catch (InvalidArgumentException $e) {
            Log::error('Invalid argument: ' . $e->getMessage());
            return new JsonResponse([
                'title' => 'Invalid Input',
                'status' => JsonResponse::HTTP_BAD_REQUEST,
                'detail' => $e->getMessage()
            ], JsonResponse::HTTP_BAD_REQUEST);

        } catch (DomainException $e) {
            Log::warning('Domain error: ' . $e->getMessage());
            return new JsonResponse([
                'title' => 'Domain Error',
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'detail' => $e->getMessage()
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);

        } catch (Exception $e) {
            Log::error('Server error: ' . $e->getMessage());
            Log::error('Error class: ' . get_class($e));

            return new JsonResponse([
                'title' => 'Internal Server Error',
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'detail' => config('app.debug') ? $e->getMessage() : 'Error interno del servidor'
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
