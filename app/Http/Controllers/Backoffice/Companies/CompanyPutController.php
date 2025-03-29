<?php
declare(strict_types=1);

namespace App\Http\Controllers\Backoffice\Companies;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use MedineTech\Backoffice\Companies\Application\Update\CompanyUpdater;
use MedineTech\Backoffice\Companies\Application\Update\CompanyUpdaterRequest;
use MedineTech\Backoffice\Companies\Domain\CompanyNotFound;
use MedineTech\Backoffice\Companies\Infrastructure\Authorization\CompaniesPermissions;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Put(
 *     path="/api/backoffice/{tenant}/companies/{id}",
 *     tags={"Backoffice - Companies"},
 *     summary="Update an existing company",
 *     security={ {"bearerAuth": {} } },
 *     @OA\Parameter(name="id", in="path", required=true, description="The ID of the company to update", @OA\Schema(type="string", format="uuid")),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(required={"name"}, @OA\Property(property="name", type="string", example="New Company Name"))
 *     ),
 *     @OA\Response(response=200, description="Company updated successfully"),
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
 *             @OA\Property(property="title", type="string", example="Error"),
 *             @OA\Property(property="status", type="integer", example=500),
 *             @OA\Property(property="detail", type="string", example="An unexpected error occurred while processing your request.")
 *         )
 *     )
 * )
 */
final class CompanyPutController extends ApiController
{
    public function __construct(
        private readonly CompanyUpdater $updater
    ) {
    }

    public function __invoke(string $id, Request $request): JsonResponse
    {
        return $this->execute(function () use ($id, $request) {
            if (!$request->user()->can(CompaniesPermissions::UPDATE)) {
                throw new UnauthorizedException(403);
            }

            $validatedData = $request->validate([
                'name' => 'required|string|min:3|max:40',
            ]);

            $updaterRequest = new CompanyUpdaterRequest(
                $id,
                $validatedData['name']
            );

            DB::transaction(function () use ($updaterRequest) {
                ($this->updater)($updaterRequest);
            });

            return new JsonResponse(null, Response::HTTP_OK);
        });
    }

    protected function exceptions(): array
    {
        return [
            ValidationException::class => Response::HTTP_BAD_REQUEST,
            CompanyNotFound::class => Response::HTTP_NOT_FOUND,
            UnauthorizedException::class => Response::HTTP_FORBIDDEN,
        ];
    }

    protected function exceptionDetail(\Exception $error): string
    {
        if ($error instanceof ValidationException) {
            return 'The given data was invalid.';
        }

        if ($error instanceof CompanyNotFound) {
            return 'Company not found with the provided ID.';
        }

        return parent::exceptionDetail($error);
    }
}
