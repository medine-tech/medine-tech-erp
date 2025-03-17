<?php

namespace App\Http\Controllers\Backoffice\Companies;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use MedineTech\Backoffice\Companies\Application\Create\CompanyCreator;
use MedineTech\Backoffice\Companies\Application\Create\CompanyCreatorRequest;
use MedineTech\Backoffice\Companies\Infrastructure\Authorization\CompaniesPermissions;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @OA\Post(
 *     path="/api/backoffice/companies",
 *     tags={"Backoffice - Companies"},
 *     summary="Create a new company",
 *     security={ {"bearerAuth": {} } },
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             required={"id", "name"},
 *             @OA\Property(property="id", type="string", format="uuid", example="123e4567-e89b-12d3-a456-426655440000"),
 *             @OA\Property(property="name", type="string", example="MedineTech")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Company created successfully"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Validation error",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="title", type="string", example="Validation Error"),
 *             @OA\Property(property="status", type="integer", example=400),
 *             @OA\Property(property="detail", type="string", example="The given data was invalid."),
 *             @OA\Property(property="errors", type="object")
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
 *             @OA\Property(property="detail", type="string", example="An unexpected error occurred while processing your request.")
 *         )
 *     )
 * )
 */
final class CompanyPostController
{
    public function __construct(private readonly CompanyCreator $creator)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            if (!$request->user()->can(CompaniesPermissions::CREATE)) {
                throw new UnauthorizedException(403);
            }

            $validatedData = $request->validate([
                'id' => 'required|string|uuid',
                'name' => 'required|string|min:3|max:40',
            ]);

            $creatorRequest = new CompanyCreatorRequest(
                $validatedData['id'],
                $validatedData['name'],
                $request->user()->id
            );

            DB::transaction(function () use ($creatorRequest) {
                ($this->creator)($creatorRequest);
            });

            return new JsonResponse(null, 201);
        } catch (ValidationException $e) {
            return new JsonResponse([
                'title' => 'Validation Error',
                'status' => JsonResponse::HTTP_BAD_REQUEST,
                'detail' => 'The given data was invalid.',
                'errors' => $e->errors(),
            ], JsonResponse::HTTP_BAD_REQUEST);
        } catch (UnauthorizedException) {
            return response()->json([
                "title" => "Unauthorized",
                "detail" => "You do not have permission to view this resource.",
                "status" => 403,
            ], 403);
        } catch (Exception $e) {
            return new JsonResponse([
                'title' => 'Internal Server Error',
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'detail' => 'An unexpected error occurred while processing your request.',
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
