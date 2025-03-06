<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backoffice\Companies;

use MedineTech\Backoffice\Companies\Application\Find\CompanyFinder;
use MedineTech\Backoffice\Companies\Application\Find\CompanyFinderRequest;
use MedineTech\Backoffice\Companies\Domain\CompanyNotFound;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @OA\Get(
 *     path="/companies/{id}",
 *     tags={"Companies"},
 *     summary="Get a company by ID",
 *     description="Returns the details of a company based on the provided ID.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="The ID of the company to retrieve",
 *         @OA\Schema(type="string", format="uuid", example="123e4567-e89b-12d3-a456-426655440000")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Company details retrieved successfully"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Company not found"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
final class CompanyGetController
{
    public function __construct(
        private readonly CompanyFinder $finder
    )
    {
    }

    public function __invoke(string $id, Request $request): JsonResponse
    {
        try {
            $response = ($this->finder)(new CompanyFinderRequest(
                (string)$id
            ));

            return new JsonResponse([
                'id' => $response->id(),
                'name' => $response->name()
            ], JsonResponse::HTTP_OK);
        } catch (CompanyNotFound $exception) {
            return new JsonResponse([
                'message' => $exception->getMessage()
            ], JsonResponse::HTTP_NOT_FOUND);
        }
    }
}
