<?php

namespace App\Http\Controllers\Backoffice\Security\RolePermissions;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use MedineTech\Backoffice\Security\RolePermissions\Application\Delete\RolePermissionDeleterRequest;
use MedineTech\Backoffice\Security\RolePermissions\Application\Delete\RolePermissionDeleter;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\JsonResponse;

final class RolePermissionDetachDeleteController
{
    public function __construct(
        private RolePermissionDeleter $deleter
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'roleId' => 'required|int',
                'permissionId' => 'required|int',
            ]);

            $deleterRequest = new RolePermissionDeleterRequest(
                $validated['roleId'],
                $validated['permissionId']
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
                'errors' => $e->errors(),
            ], JsonResponse::HTTP_BAD_REQUEST);
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
