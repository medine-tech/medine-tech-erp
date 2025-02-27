<?php

namespace App\Http\Controllers\Companies;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use MedineTech\Companies\Application\Create\CompanyCreator;
use MedineTech\Companies\Application\Create\CompanyCreatorRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CompaniesPostController
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
                'id' => 'required|uuid',
                'data' => 'required|array',
            ]);

            $creatorRequest = new CompanyCreatorRequest(
                $validatedData['id'],
                $validatedData['data']
            );

            ($this->creator)($creatorRequest);

            return new JsonResponse(null, 201);
        } catch (ValidationException $e) {
            return new JsonResponse([
                'title' => 'Validation Error',
                'status' => 400,
                'detail' => $e->errors(),
            ], 400);
        } catch (Exception $e) {
            return new JsonResponse([
                'title' => 'Error',
                'status' => 500,
                'detail' => 'An error occurred while creating the company.',
            ], 500);
        }
    }
}
