<?php

namespace App\Http\Controllers\Companies;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use MedineTech\Companies\Application\Create\CompanyCreator;
use MedineTech\Companies\Application\Create\CompanyCreatorRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @OA\Post(
 *     path="/api/companies",
 *     tags={"Companies"},
 *     summary="Create a new company",
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             required={"id", "name"},
 *             @OA\Property(property="id", type="string", example="123e4567-e89b-12d3-a456-426655440000"),
 *             @OA\Property(property="name", type="string", example="MedineTech")
 *         )
 *     ),
 *     @OA\Response(
 *          response=201,
 *          description="Company created successfully"
 *     ),
 *     @OA\Response(
 *          response=400,
 *          description="Validation error"
 *     ),
 *     @OA\Response(
 *          response=500,
 *          description="Internal server error"
 *     )
 * )
 */

final class CompanyPostController
{
    public function __construct(
        private readonly CompanyCreator $creator
    )
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'id' => 'required|string',
                'name' => 'required|string|min:3|max:40',
            ]);

            $creatorRequest = new CompanyCreatorRequest(
                $validatedData['id'],
                $validatedData['name']
            );

            ($this->creator)($creatorRequest);

            return new JsonResponse('', 201);
        } catch (ValidationException $e) {
            return new JsonResponse([
                'title' => 'Validation Error',
                'status' => 400,
                'detail' => 'The given data was invalid.',
                'errors' => $e->errors(),
            ], 400);
        } catch (Exception $e) {
            return new JsonResponse([
                'title' => 'Error',
                'status' => 500,
                'detail' => 'An unexpected error occurred while processing your request.',
            ], 500);
        }
    }
}
