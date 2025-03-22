<?php
declare(strict_types=1);

namespace App\Http\Controllers\Backoffice\Security\Roles;

use App\Http\Controllers\ApiController;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use MedineTech\Backoffice\Security\Roles\Application\Create\RoleCreator;
use MedineTech\Backoffice\Security\Roles\Application\Create\RoleCreatorRequest;
use MedineTech\Backoffice\Security\Roles\Infrastructure\Authorization\RolesPermissions;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Post(
 *     path="/api/backoffice/{tenant}/security/roles",
 *     tags={"Backoffice - Security - Roles"},
 *     summary="Create a new role",
 *     description="Creates a new role with the provided details.",
 *     security={ {"bearerAuth": {} } },
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             required={"name"},
 *             @OA\Property(property="name", type="string", example="Admin", description="The name of the role."),
 *             @OA\Property(property="description", type="string", example="Administrator role", nullable=true, description="A brief description of the role.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Role created successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Role created successfully.")
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
 *         response=403,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="title", type="string", example="Unauthorized"),
 *             @OA\Property(property="status", type="integer", example=403),
 *             @OA\Property(property="detail", type="string", example="You do not have permission to create this resource.")
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
final class RolePostController extends ApiController
{
    public function __construct(
        private readonly RoleCreator $creator
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        if (!$request->user()->can(RolesPermissions::UPDATE)) {
            throw new UnauthorizedException(Response::HTTP_FORBIDDEN);
        }

        return $this->execute(function () use ($request) {
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

            DB::transaction(function () use ($creatorRequest) {
                ($this->creator)($creatorRequest);
            });

            return new JsonResponse(null, Response::HTTP_CREATED);
        });
    }

    protected function exceptions(): array
    {
        return [
            ValidationException::class => Response::HTTP_BAD_REQUEST,
            UnauthorizedException::class => Response::HTTP_FORBIDDEN
        ];
    }

    protected function exceptionDetail(Exception $error): string
    {
        if ($error instanceof ValidationException) {
            return 'The given data was invalid.';
        }

        if ($error instanceof UnauthorizedException) {
            return 'You do not have permission to view this resource.';
        }

        return parent::exceptionDetail($error);
    }
}
