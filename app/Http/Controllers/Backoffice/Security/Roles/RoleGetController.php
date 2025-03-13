<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backoffice\Security\Roles;

use Exception;
use Illuminate\Http\Request;
use MedineTech\Backoffice\Security\Roles\Application\Find\RoleFinder;
use MedineTech\Backoffice\Security\Roles\Application\Find\RoleFinderRequest;
use MedineTech\Backoffice\Security\Roles\Domain\RoleNotFound;
use MedineTech\Backoffice\Security\Roles\Infrastructure\Authorization\RolesPermissions;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\JsonResponse;

final class RoleGetController
{
    public function __construct(
        private RoleFinder $finder
    )
    {
    }

    public function __invoke(int $id, Request $request): JsonResponse
    {
        try {
//            if (!$request->user()->can(RolesPermissions::VIEW)) {
//                throw new UnauthorizedException(403);
//            }

            $response = ($this->finder)(
                new RoleFinderRequest($id)
            );

            return new JsonResponse([
                'id' => $response->id(),
                'code' => $response->code(),
                'name' => $response->name(),
                'description' => $response->description(),
                'status' => $response->status(),
                'creatorId' => $response->creatorId(),
                'updaterId' => $response->updaterId(),
                'companyId' => $response->companyId(),
            ], JsonResponse::HTTP_OK);
        }catch (RoleNotFound $e) {
            return new JsonResponse([
                'title' => 'Accounting account not found',
                'status' => JsonResponse::HTTP_NOT_FOUND,
                'detail' => "The accounting account with id <$id> does not exist."
            ], JsonResponse::HTTP_NOT_FOUND);
        } catch (UnauthorizedException $e) {
            return new JsonResponse([
                'title' => 'Unauthorized',
                'status' => JsonResponse::HTTP_FORBIDDEN,
                'detail' => 'You are not authorized to view this accounting account.'
            ], JsonResponse::HTTP_FORBIDDEN);
        } catch (Exception $e) {
            return new JsonResponse([
                'title' => 'Internal Server Error',
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'detail' => 'An error occurred while processing your request.',
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
