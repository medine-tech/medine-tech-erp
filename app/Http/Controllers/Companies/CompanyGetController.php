<?php

declare(strict_types=1);

namespace App\Http\Controllers\Companies;

use MedineTech\Companies\Application\Find\CompanyFinder;
use MedineTech\Companies\Application\Find\CompanyFinderRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class CompanyGetController
{
    public function __construct(
        private readonly CompanyFinder $finder
    )
    {
    }

    public function __invoke(string $id, Request $request): JsonResponse
    {
        $response = ($this->finder)(new CompanyFinderRequest(
            (string)$id
        ));

        return new JsonResponse([
            'id' => $response->id(),
            'name' => $response->name()
        ], JsonResponse::HTTP_OK);
    }
}
