<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backoffice\Security\Roles;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use MedineTech\Backoffice\Security\Roles\Application\Create\RoleCreator;
use MedineTech\Backoffice\Security\Roles\Application\Create\RoleCreatorRequest;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\JsonResponse;

final class RolePostController
{
    public function __construct(
        private readonly RoleCreator $creator
    )
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
//            if (!$request->user()->can(RolesPermissions::CREATE)) {
//                throw new UnauthorizedException(403);
//            }

            $validatedData = $request->validate([
                'name' => 'required|string|min:3|max:40',
                'description' => 'nullable|string|min:3|max:100'
            ]);

            $userId = $request->user()->id;

            $creatorRequest = new RoleCreatorRequest(
                $validatedData['name'],
                $validatedData['description'],
                $userId,
                tenant('id')
            );

            ($this->creator)($creatorRequest);

            return new JsonResponse(null, 201);
        } catch (ValidationException $exception) {
            return new JsonResponse([
                'title' => 'Validation Error',
                'status' => JsonResponse::HTTP_BAD_REQUEST,
                'detail' => 'The given data was invalid.',
                'errors' => $exception->errors(),
            ], JsonResponse::HTTP_BAD_REQUEST);
        } catch (UnauthorizedException $exception) {
            return new JsonResponse([
                'title' => 'Unauthorized',
                'status' => JsonResponse::HTTP_FORBIDDEN,
                'detail' => 'You do not have permission to view this resource.',
            ], JsonResponse::HTTP_FORBIDDEN);
        } catch (Exception $exception) {
            return new JsonResponse([
                'title' => 'Internal Server Error',
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'detail' => 'An unexpected error occurred while processing your request.',
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
