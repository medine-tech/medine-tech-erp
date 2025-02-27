<?php

namespace App\Http\Controllers\Companies;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use MedineTech\Companies\Application\Create\CompanyCreator;
use MedineTech\Companies\Application\Create\CompanyCreatorRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

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
                'name' => 'required|string',
            ]);

            $creatorRequest = new CompanyCreatorRequest(
                $validatedData['name']
            );

            ($this->creator)($creatorRequest);

            return new JsonResponse('', 201);
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
                'detail' => 'An unexpected error occurred while processing your request.',
            ], 500);
        }
    }
}
