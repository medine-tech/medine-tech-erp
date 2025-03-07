<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backoffice\Companies;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use MedineTech\Backoffice\Companies\Application\Update\CompanyUpdater;
use MedineTech\Backoffice\Companies\Application\Update\CompanyUpdaterRequest;
use MedineTech\Backoffice\Companies\Domain\CompanyNotFound;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @OA\Put(
 *     path="api/backoffice/companies/{id}",
 *     tags={"Backoffice - Companies"},
 *     summary="Update an existing company",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="The ID of the company to update",
 *         @OA\Schema(type="string", format="uuid")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name"},
 *             @OA\Property(property="name", type="string", example="New Company Name")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Company updated successfully"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Validation error",
 *         @OA\JsonContent(
 *             @OA\Property(property="title", type="string", example="Validation Error"),
 *             @OA\Property(property="status", type="integer", example=400),
 *             @OA\Property(property="detail", type="string", example="The given data was invalid."),
 *             @OA\Property(property="errors", type="object")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Company not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="title", type="string", example="Not Found"),
 *             @OA\Property(property="status", type="integer", example=404),
 *             @OA\Property(property="detail", type="string", example="Company not found with the provided ID.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error",
 *         @OA\JsonContent(
 *             @OA\Property(property="title", type="string", example="Internal Server Error"),
 *             @OA\Property(property="status", type="integer", example=500),
 *             @OA\Property(property="detail", type="string", example="An unexpected error occurred while processing your request.")
 *         )
 *     )
 * )
 */
final class CompanyPutController
{
    public function __construct(
        private readonly CompanyUpdater $updater
    )
    {
    }

    public function __invoke(string $id, Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|min:3|max:40',
            ]);

            $updaterRequest = new CompanyUpdaterRequest(
                $id,
                $validatedData['name']
            );

            ($this->updater)($updaterRequest);

            return new JsonResponse('', JsonResponse::HTTP_OK);
        } catch (ValidationException $e) {
            return new JsonResponse([
                'title' => 'Validation Error',
                'status' => JsonResponse::HTTP_BAD_REQUEST,
                'detail' => 'The given data was invalid.',
                'errors' => $e->errors(),
            ], JsonResponse::HTTP_BAD_REQUEST);
        } catch (CompanyNotFound $e) {
            return new JsonResponse([
                'title' => 'Not Found',
                'status' => JsonResponse::HTTP_NOT_FOUND,
                'detail' => 'Company not found with the provided ID.',
            ], JsonResponse::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return new JsonResponse([
                'title' => 'Error',
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'detail' => 'An unexpected error occurred while processing your request.',
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
