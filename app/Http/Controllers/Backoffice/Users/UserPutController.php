<?php
declare(strict_types=1);

namespace App\Http\Controllers\Backoffice\Users;

use App\Models\User;
use DomainException;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use MedineTech\Backoffice\Users\Application\Update\UserUpdater;
use MedineTech\Backoffice\Users\Application\Update\UserUpdaterRequest;

/**
 * @OA\Put(
 *     path="/api/backoffice/users/{id}",
 *     tags={"Backoffice - Users"},
 *     summary="Update an existing user",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="User ID",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             required={"name", "email"},
 *             @OA\Property(
 *                 property="name",
 *                 type="string",
 *             ),
 *             @OA\Property(
 *                 property="email",
 *                 type="string",
 *                 format="email",
 *                 example="newuser@example.com"
 *             ),
 *             @OA\Property(
 *                 property="password",
 *                 type="string",
 *                 example="newPassword123",
 *                 nullable=true
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User updated successfully"
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
 *         response=404,
 *         description="User Not Found",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="title", type="string", example="User Not Found"),
 *             @OA\Property(property="status", type="integer", example=404),
 *             @OA\Property(property="detail", type="string", example="User with the given ID does not exist")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="title", type="string", example="Internal Server Error"),
 *             @OA\Property(property="status", type="integer", example=500),
 *             @OA\Property(property="detail", type="string", example="An unexpected error occurred")
 *         )
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

            return new JsonResponse(
                ['message' => 'User updated successfully'],
                JsonResponse::HTTP_OK
            );
        } catch (\Illuminate\Validation\ValidationException $e) {
            return new JsonResponse([
                'title'  => 'Validation Error',
                'status' => JsonResponse::HTTP_BAD_REQUEST,
                'detail' => $e->getMessage(),
                'errors' => $e->errors()
            ], JsonResponse::HTTP_BAD_REQUEST);

        } catch (InvalidArgumentException $e) {
            return new JsonResponse([
                'title'  => 'Internal Server Error',
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'detail' => 'An Unexpected Error Occurred'
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);

        } catch (DomainException $e) {
            return new JsonResponse([
                'title'  => 'Internal Server Error',
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'detail' => 'An Unexpected Error Occurred'
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);

        } catch (Exception $e) {
            return new JsonResponse([
                'title'  => 'Internal Server Error',
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'detail' => 'An Unexpected Error Occurred'
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
