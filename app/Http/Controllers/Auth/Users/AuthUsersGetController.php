<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth\Users;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use MedineTech\Auth\Users\Application\Search\AuthUserSearcherResponse;
use MedineTech\Auth\Users\Application\Search\AuthUsersSearcher;
use MedineTech\Auth\Users\Application\Search\AuthUsersSearcherRequest;
use MedineTech\Auth\Users\Infrastructure\Authorization\AuthUsersPermissions;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;
use function Lambdish\Phunctional\map;

final class AuthUsersGetController extends ApiController
{
    public function __construct(
        private readonly AuthUsersSearcher $searcher
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        return $this->execute(function () use ($request) {
            $user = $request->user();

//            if (!$user->can(AuthUsersPermissions::VIEW)) {
//                throw new UnauthorizedException(403);
//            }

            $filters = (array)$request->query();
            $filters["userId"] = $user->id;
            $response = ($this->searcher)(new AuthUsersSearcherRequest($filters));

            return new JsonResponse([
                'items' => map(function (AuthUserSearcherResponse $response) {
                    return [
                        'id' => $response->id(),
                        'name' => $response->name(),
                        'email' => $response->email(),
                        'default_company_id' => $response->defaultCompanyId(),
                    ];
                }, $response->items()),
                'total' => $response->total(),
                'per_page' => $response->perPage(),
                'current_page' => $response->currentPage(),
            ], Response::HTTP_OK);
        });
    }
}
