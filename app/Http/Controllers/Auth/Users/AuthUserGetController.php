<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth\Users;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use MedineTech\Auth\Users\Application\Find\AuthUserFinder;
use MedineTech\Auth\Users\Application\Find\AuthUserFinderRequest;
use Symfony\Component\HttpFoundation\Response;

final class AuthUserGetController extends ApiController
{
    public function __construct(
        private AuthUserFinder $finder
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        return $this->execute(function () use ($request) {
            $user = ($this->finder)(new AuthUserFinderRequest($request->id));
            return new JsonResponse([
                'id' => $user->id(),
                'name' => $user->name()
            ], Response::HTTP_OK);
        });
    }
}
