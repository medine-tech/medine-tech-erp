<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth\Users;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use MedineTech\Auth\Users\Application\Find\AuthUserFinder;
use MedineTech\Auth\Users\Application\Find\AuthUserFinderRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Get(
 *     path="/api/auth/user",
 *     summary="Get specific users information",
 *     tags={"Auth - User"},
 *     security={
 *         {"bearerAuth": {}}
 *     },
 *     @OA\Response(
 *         response=200,
 *         description="Successfully retrieved users information",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="string", example="f7c5bdb2-1f8e-4f19-9c6d-f8c4a4d54a9a"),
 *             @OA\Property(property="name", type="string", example="John Doe"),
 *             @OA\Property(property="email", type="string", example="john.doe@example.com"),
 *             @OA\Property(property="defaultCompanyId", type="string", example="comp-123")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="title", type="string", example="Resource not found"),
 *             @OA\Property(property="status", type="integer", example=404),
 *             @OA\Property(property="detail", type="string", example="The requested users does not exist.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal Server Error",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="title", type="string", example="Internal Server Error"),
 *             @OA\Property(property="detail", type="string", example="An unexpected error occurred"),
 *             @OA\Property(property="status", type="integer", example=500)
 *         )
 *     )
 * )
 */
final class AuthUserGetController extends ApiController
{
    public function __construct(
        private AuthUserFinder $finder
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        return $this->execute(function () use ($request) {
            $user = $request->user()->id;

            $response = ($this->finder)(new AuthUserFinderRequest($user));

            return new JsonResponse([
                'id' => $response->id(),
                'name' => $response->name(),
                'email' => $response->email(),
                'defaultCompanyId' => $response->defaultCompanyId(),
            ], Response::HTTP_OK);
        });
    }
}
