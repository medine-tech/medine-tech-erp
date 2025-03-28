<?php
declare(strict_types=1);

namespace App\Http\Controllers\Backoffice\Users;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use MedineTech\Backoffice\Users\Application\Update\UserUpdater;
use MedineTech\Backoffice\Users\Application\Update\UserUpdaterRequest;
use MedineTech\Backoffice\Users\Domain\UserNotFound;
use MedineTech\Backoffice\Users\Infrastructure\Authorization\UsersPermissions;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

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
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             required={"name"},
 *             @OA\Property(property="name", type="string")
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
 *         response=403,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             @OA\Property(property="title", type="string", example="Unauthorized"),
 *             @OA\Property(property="status", type="integer", example=403),
 *             @OA\Property(property="detail", type="string", example="You do not have permission to view this resource.")
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
 *     ),
 *     security={
 *         {"bearerAuth":{}}
 *     }
 * )
 */
final class UserPutController extends ApiController
{
    public function __construct(
        private readonly UserUpdater $updater
    ) {
    }

    public function __invoke(int $id, Request $request): JsonResponse
    {
        return $this->execute(function () use ($id, $request) {
            if (!$request->user()->can(UsersPermissions::UPDATE)) {
                throw new UnauthorizedException(403);
            }

            $validatedData = $request->validate([
                'name' => 'required|string|min:3|max:30'
            ]);

            $updaterRequest = new UserUpdaterRequest(
                $id,
                $validatedData['name']
            );

            DB::transaction(function () use ($updaterRequest) {
                ($this->updater)($updaterRequest);
            });

            return new JsonResponse(null, Response::HTTP_OK);
        });
    }

    protected function exceptions(): array
    {
        return [
            ValidationException::class => Response::HTTP_BAD_REQUEST,
            UserNotFound::class => Response::HTTP_NOT_FOUND,
            UnauthorizedException::class => Response::HTTP_FORBIDDEN,
        ];
    }

    protected function exceptionDetail(\Exception $error): string
    {
        if ($error instanceof ValidationException) {
            return 'The given data was invalid.';
        }

        return parent::exceptionDetail($error);
    }
}
