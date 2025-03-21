<?php

namespace App\Http\Controllers\Backoffice\Security\RolePermissions;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use MedineTech\Backoffice\Security\RolePermissions\Application\Delete\RolePermissionDeleterRequest;
use MedineTech\Backoffice\Security\RolePermissions\Application\Delete\RolePermissionDeleter;
use Illuminate\Http\Request;
use MedineTech\Backoffice\Security\RolePermissions\Domain\RolePermissionNotFoundException;
use MedineTech\Backoffice\Security\RolePermissions\Infrastructure\Authorization\RolePermissionPermissions;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\JsonResponse;

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
final class RolePermissionDeleteController
{
    public function __construct(
        private RolePermissionDeleter $deleter
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        if (!$request->user()->can(RolePermissionPermissions::DELETE)) {
            throw new UnauthorizedException(JsonResponse::HTTP_FORBIDDEN);
        }

        try {
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

            return new JsonResponse(null, JsonResponse::HTTP_OK);
        } catch (ValidationException $e) {
            return new JsonResponse([
                'title' => 'Validation Error',
                'status' => JsonResponse::HTTP_BAD_REQUEST,
                'detail' => 'The given data was invalid.',
                'errors' => $e->errors()
            ], JsonResponse::HTTP_BAD_REQUEST);
        } catch (RolePermissionNotFoundException $e) {
            return new JsonResponse([
                'title' => 'Not Found',
                'status' => JsonResponse::HTTP_NOT_FOUND,
                'detail' => 'Role permission not found.'
            ], JsonResponse::HTTP_NOT_FOUND);
        } catch (UnauthorizedException) {
            return response()->json([
                "title" => "Unauthorized",
                "status" => JsonResponse::HTTP_FORBIDDEN,
                "detail" => 'You do not have permission to view this resource.'
            ], JsonResponse::HTTP_FORBIDDEN);
        } catch (Exception $e) {
            return new JsonResponse([
                'title' => 'Internal Server Error',
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'detail' => 'An unexpected error occurred while processing your request.'
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
