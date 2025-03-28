<?php
declare(strict_types=1);

namespace App\Http\Controllers\Backoffice\Security\Roles;

use App\Http\Controllers\ApiController;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use MedineTech\Backoffice\Security\Roles\Application\Update\RoleUpdater;
use MedineTech\Backoffice\Security\Roles\Application\Update\RoleUpdaterRequest;
use MedineTech\Backoffice\Security\Roles\Domain\RoleNotFound;
use MedineTech\Backoffice\Security\Roles\Infrastructure\Authorization\RolesPermissions;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Put(
 *     path="/api/backoffice/{tenant}/security/roles/{id}",
 *     tags={"Backoffice - Security - Roles"},
 *     summary="Update an existing role",
 *     description="Updates an existing role with the provided details.",
 *     security={ {"bearerAuth": {} } },
 *     @OA\Parameter(
 *         name="tenant",
 *         in="path",
 *         required=true,
 *         description="The tenant ID",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="The ID of the role to update",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "status"},
 *             @OA\Property(property="name", type="string", example="Updated Role Name", description="The name of the role."),
 *             @OA\Property(property="description", type="string", example="Updated role description", nullable=true, description="A brief description of the role."),
 *             @OA\Property(property="status", type="string", example="INACTIVE", description="Role status")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Role updated successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Role updated successfully.")
 *         )
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
 *         description="Role not found",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="title", type="string", example="Not Found"),
 *             @OA\Property(property="status", type="integer", example=404),
 *             @OA\Property(property="detail", type="string", example="Role not found with the provided ID.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="title", type="string", example="Unauthorized"),
 *             @OA\Property(property="status", type="integer", example=403),
 *             @OA\Property(property="detail", type="string", example="You do not have permission to update this resource.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="title", type="string", example="Internal Server Error"),
 *             @OA\Property(property="status", type="integer", example=500),
 *             @OA\Property(property="detail", type="string", example="An unexpected error occurred while processing your request.")
 *         )
 *     )
 * )
 */
final class RolePutController extends ApiController
{
    public function __construct(
        private readonly RoleUpdater $updater
    ) {
    }

    public function __invoke(int $id, Request $request): JsonResponse
    {
        if (!$request->user()->can(RolesPermissions::UPDATE)) {
            throw new UnauthorizedException(403);
        }

        return $this->execute(function () use ($id, $request) {
            $validatedData = $request->validate([
                'name' => 'required|string',
                'description' => 'nullable|string',
                'status' => 'required|string',
            ]);

            $userId = $request->user()->id;

            $updaterRequest = new RoleUpdaterRequest(
                $id,
                $validatedData['name'],
                $validatedData['description'],
                $validatedData['status'],
                $userId,
                tenant('id')
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
            RoleNotFound::class => Response::HTTP_NOT_FOUND,
            UnauthorizedException::class => Response::HTTP_FORBIDDEN
        ];
    }

    protected function exceptionDetail(Exception $error): string
    {
        if ($error instanceof ValidationException) {
            return 'The given data was invalid.';
        }

        if ($error instanceof RoleNotFound) {
            return 'Role not found with the provided ID.';
        }

        if ($error instanceof UnauthorizedException) {
            return 'You do not have permission to update this resource.';
        }

        return parent::exceptionDetail($error);
    }
}
