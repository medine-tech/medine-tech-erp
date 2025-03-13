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

/**
 * @OA\Get(
 *     path="/api/backoffice/{tenant}/security/roles/{id}",
 *     tags={"Backoffice - Security - Roles"},
 *     summary="Get a role by ID",
 *     description="Returns the details of a role based on the provided ID.",
 *     security={
 *         {"bearerAuth": {}}
 *     },
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
 *         description="The ID of the role to retrieve",
 *         @OA\Schema(
 *             type="integer",
 *             example=1
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Role details retrieved successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="code", type="string", example="ROL23000001"),
 *             @OA\Property(property="name", type="string", example="Admin"),
 *             @OA\Property(property="description", type="string", example="Administrator role", nullable=true),
 *             @OA\Property(property="status", type="string", example="ACTIVE", description="Role status"),
 *             @OA\Property(property="creatorId", type="integer", example=1),
 *             @OA\Property(property="updaterId", type="integer", example=1),
 *             @OA\Property(property="companyId", type="string", example="company-123")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Role not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="title", type="string", example="Role not found"),
 *             @OA\Property(property="status", type="integer", example=404),
 *             @OA\Property(property="detail", type="string", example="The role with id <1> does not exist.")
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
 *         description="Internal Server Error",
 *         @OA\JsonContent(
 *             @OA\Property(property="title", type="string", example="Internal Server Error"),
 *             @OA\Property(property="status", type="integer", example=500),
 *             @OA\Property(property="detail", type="string", example="An unexpected error occurred.")
 *         )
 *     )
 * )
 */
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
            if (!$request->user()->can(RolesPermissions::UPDATE)) {
                throw new UnauthorizedException(JsonResponse::HTTP_FORBIDDEN);
            }

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
                'title' => 'Role not found',
                'status' => JsonResponse::HTTP_NOT_FOUND,
                'detail' => "The role account with id <$id> does not exist."
            ], JsonResponse::HTTP_NOT_FOUND);
        } catch (UnauthorizedException $e) {
            return new JsonResponse([
                'title' => 'Unauthorized',
                'status' => JsonResponse::HTTP_FORBIDDEN,
                'detail' => 'You are not authorized to view this role.'
            ], JsonResponse::HTTP_FORBIDDEN);
        } catch (Exception $e) {
            return new JsonResponse([
                'title' => 'Internal Server Error',
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'detail' => 'An error occurred while processing your request.'
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
