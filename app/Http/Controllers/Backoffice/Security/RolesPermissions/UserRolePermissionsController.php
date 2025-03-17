<?php
// File: app/Http/Controllers/Backoffice/Security/RolesPermissions/UserRolePermissionsController.php

namespace App\Http\Controllers\Backoffice\Security\RolesPermissions;

use MedineTech\Backoffice\Security\RolesPermissions\Application\Attach\AttachRoleOnUserCreated;
use MedineTech\Backoffice\Security\RolesPermissions\Application\Detach\DetachRoleOnUserCreated;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

final class UserRolePermissionsController
{
    public function __construct(
        private AttachRoleOnUserCreated $attachRoleOnUserCreated,
        private DetachRoleOnUserCreated $detachRoleOnUserCreated
    ) {
    }

    public function attachPermission(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'roleId' => 'required|int|exists:roles,id',
            'permissionId' => 'required|string|exists:permissions,id',
        ]);

        $roleId = (int)$validated['roleId'];
        $permissionId = $validated['permissionId'];
        ($this->attachRoleOnUserCreated)($roleId, $permissionId);

        return new JsonResponse(null, JsonResponse::HTTP_OK);
    }

    public function detachPermission(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'roleId' => 'required|int|exists:roles,id',
            'permissionId' => 'required|string|exists:permissions,id',
        ]);

        $roleId = (int)$validated['roleId'];
        $permissionId = $validated['permissionId'];
        ($this->detachRoleOnUserCreated)($roleId, $permissionId);

        return new JsonResponse(null, JsonResponse::HTTP_OK);
    }
}
