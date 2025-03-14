<?php
declare(strict_types=1);

namespace App\Http\Controllers\Backoffice\Security\Roles;

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

final class RolePutController
{
    public function __construct(
        private readonly RoleUpdater $updater
    )
    {
    }

    public function __invoke(int $id, Request $request): JsonResponse
    {
        try {
            if (!$request->user()->can(RolesPermissions::UPDATE)) {
                throw new UnauthorizedException(JsonResponse::HTTP_FORBIDDEN);
            }

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

            return new JsonResponse(null, JsonResponse::HTTP_OK);
        } catch (ValidationException $e) {
            return new JsonResponse([
                'title' => 'Validation Error',
                'status' => JsonResponse::HTTP_BAD_REQUEST,
                'errors' => $e->errors(),
            ], JsonResponse::HTTP_BAD_REQUEST);
        } catch (RoleNotFound $e) {
            return new JsonResponse([
                'title' => 'Not Found',
                'status' => JsonResponse::HTTP_NOT_FOUND,
                'detail' => 'Accounting account not found with the provided ID.',
            ], JsonResponse::HTTP_NOT_FOUND);
        } catch (UnauthorizedException $e) {
            return new JsonResponse([
                'title' => 'Unauthorized',
                'status' => JsonResponse::HTTP_FORBIDDEN,
                'detail' => 'You do not have permission to view this resource.',
            ], JsonResponse::HTTP_FORBIDDEN);
        } catch (Exception $e) {
            return new JsonResponse([
                'title' => 'Error',
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'detail' => 'An unexpected error occurred while processing your request.'
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
