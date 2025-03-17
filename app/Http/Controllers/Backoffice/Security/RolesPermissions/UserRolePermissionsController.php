<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backoffice\Security\RolesPermissions;

use MedineTech\Backoffice\Security\UserRoles\Application\Attach\AttachRoleOnUserCreated;
use MedineTech\Backoffice\Security\UserRoles\Application\Detach\DetachRoleOnUserCreated;
use Illuminate\Http\Request;

final class UserRolePermissionsController
{
    public function __construct(
        private AttachRoleOnUserCreated $attachRoleOnUserCreated,
        private DetachRoleOnUserCreated $detachRoleOnUserCreated
    ) {
    }

    public function attachPermission(Request $request): void
    {
        $roleId = $request->input('roleId');
        $permissionId = $request->input('permissionId');

        ($this->attachRoleOnUserCreated)($roleId, $permissionId);
    }

    public function detachPermission(Request $request): void
    {
        $roleId = $request->input('roleId');
        $permissionId = $request->input('permissionId');

        ($this->detachRoleOnUserCreated)($roleId, $permissionId);
    }
}
