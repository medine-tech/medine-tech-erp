<?php

namespace App\Http\Controllers\Backoffice\Security\RolePermissions;

use App\Http\Controllers\ApiController;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use MedineTech\Backoffice\Security\RolePermissions\Application\Delete\RolePermissionDeleter;
use MedineTech\Backoffice\Security\RolePermissions\Application\Delete\RolePermissionDeleterRequest;
use MedineTech\Backoffice\Security\RolePermissions\Domain\RolePermissionNotFoundException;
use MedineTech\Backoffice\Security\RolePermissions\Infrastructure\Authorization\RolePermissionPermissions;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Delete(
 *     path="/api/backoffice/{tenant}/security/role-permissions",
 *     tags={"Backoffice - Security - Role Permissions"},
 *     summary="Detach a permission from a role",
 *     security={ {"bearerAuth": {} } },
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             required={"role_id", "permission_id"},
 *             @OA\Property(property="role_id", type="integer", example=1),
 *             @OA\Property(property="permission_id", type="integer", example=2)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Permission detached from role successfully"
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
 *         response=404,
 *         description="Role permission not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="title", type="string", example="Not Found"),
 *             @OA\Property(property="status", type="integer", example=404),
 *             @OA\Property(property="detail", type="string", example="Role permission not found.")
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
final class RolePermissionDeleteController extends ApiController
{
    public function __construct(
        private readonly RolePermissionDeleter $deleter
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        if (!$request->user()->can(RolePermissionPermissions::DELETE)) {
            throw new UnauthorizedException(403);
        }

        return $this->execute(function () use ($request) {
            $validated = $request->validate([
                'role_id' => 'required|int',
                'permission_id' => 'required|int',
            ]);

            $deleterRequest = new RolePermissionDeleterRequest(
                $validated['role_id'],
                $validated['permission_id']
            );

            DB::transaction(function () use ($deleterRequest) {
                ($this->deleter)($deleterRequest);
            });

            return new JsonResponse(null, Response::HTTP_OK);
        });
    }

    protected function exceptions(): array
    {
        return [
            ValidationException::class => Response::HTTP_BAD_REQUEST,
            RolePermissionNotFoundException::class => Response::HTTP_NOT_FOUND,
            UnauthorizedException::class => Response::HTTP_FORBIDDEN
        ];
    }

    protected function exceptionDetail(Exception $error): string
    {
        if ($error instanceof ValidationException) {
            return 'The given data was invalid.';
        }

        if ($error instanceof RolePermissionNotFoundException) {
            return 'Role permission not found.';
        }

        if ($error instanceof UnauthorizedException) {
            return 'You do not have permission to view this resource.';
        }

        return parent::exceptionDetail($error);
    }
}
