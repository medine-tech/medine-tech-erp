<?php
declare(strict_types=1);

namespace App\Http\Controllers\Backoffice\Users;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use MedineTech\Backoffice\Users\Application\Find\UserFinder;
use MedineTech\Backoffice\Users\Application\Find\UserFinderRequest;
use MedineTech\Backoffice\Users\Domain\UserNotFound;
use MedineTech\Backoffice\Users\Infrastructure\Authorization\UsersPermissions;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Get(
 *     path="/api/backoffice/users/{id}",
 *     tags={"Backoffice - Users"},
 *     summary="Retrieve a user by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="User ID",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User found successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="name", type="string", example="John Doe"),
 *             @OA\Property(property="email", type="email", example="e@mail.com")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User Not Found",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="title", type="string", example="User Not Found"),
 *             @OA\Property(property="status", type="integer", example=404),
 *             @OA\Property(property="detail", type="string", example="User with the given ID does not exist")
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
 *         description="Internal server error",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="title", type="string", example="Internal Server Error"),
 *             @OA\Property(property="status", type="integer", example=500),
 *             @OA\Property(property="detail", type="string", example="An Unexpected Error Occurred")
 *         )
 *     ),
 *     security={
 *         {"bearerAuth":{}}
 *     }
 * )
 */
final class UserGetController extends ApiController
{
    public function __construct(
        private readonly UserFinder $finder
    ) {
    }

    public function __invoke(int $id, Request $request): JsonResponse
    {
        return $this->execute(function () use ($id, $request) {
            if (!$request->user()->can(UsersPermissions::VIEW)) {
                throw new UnauthorizedException(403);
            }

            $response = ($this->finder)(new UserFinderRequest($id));

            return new JsonResponse([
                'id' => $response->id(),
                'name' => $response->name(),
                'email' => $response->email()
            ], JsonResponse::HTTP_OK);
        });
    }

    /**
     * Define exception mappings specific to this controller
     */
    protected function exceptions(): array
    {
        return [
            UserNotFound::class => Response::HTTP_NOT_FOUND,
        ];
    }
}
