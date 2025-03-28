<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backoffice\Accounting\AccountingCenters;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use MedineTech\Backoffice\Accounting\AccountingCenter\Application\Create\AccountingCenterCreator;
use MedineTech\Backoffice\Accounting\AccountingCenter\Application\Create\AccountingCenterCreatorRequest;
use MedineTech\Backoffice\Accounting\AccountingCenter\Infrastructure\Authorization\AccountingCenterPermissions;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Post(
 *     path="/api/backoffice/{tenant}/accounting/accounting-centers",
 *     tags={"Backoffice - Accounting - Accounting Centers"},
 *     summary="Create a new accounting center",
 *     security={ {"bearerAuth": {} } },
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             required={"id", "code", "name"},
 *             @OA\Property(property="id", type="string", format="uuid", example="123e4567-e89b-12d3-a456-426655440000"),
 *             @OA\Property(property="code", type="string", example="AC-001", maxLength=50),
 *             @OA\Property(property="name", type="string", example="Main Accounting Center", minLength=3, maxLength=40),
 *             @OA\Property(property="description", type="string", example="Main accounting center description", nullable=true),
 *             @OA\Property(property="parent_id", type="string", format="uuid", example="123e4567-e89b-12d3-a456-426655440001", nullable=true)
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Accounting center created successfully"
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
final class AccountingCenterPostController extends ApiController
{
    public function __construct(private readonly AccountingCenterCreator $creator)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        return $this->execute(function () use ($request) {
            $user = $request->user();

            if (!$user->can(AccountingCenterPermissions::CREATE)) {
                throw new UnauthorizedException(403);
            }

            $validatedData = $request->validate([
                'id' => 'required|string|uuid',
                'code' => 'required|string|max:50',
                'name' => 'required|string|min:3|max:40',
                'description' => 'nullable|string',
                'parent_id' => 'nullable|string|uuid',
            ]);

            $userId = $user->id;

            $creatorRequest = new AccountingCenterCreatorRequest(
                $validatedData['id'],
                $validatedData['code'],
                $validatedData['name'],
                $validatedData['description'] ?? null,
                $validatedData['parent_id'] ?? null,
                $userId,
                tenant('id')
            );

            DB::transaction(function () use ($creatorRequest) {
                ($this->creator)($creatorRequest);
            });

            return new JsonResponse(null, Response::HTTP_CREATED);
        });
    }

    protected function exceptions(): array
    {
        return [
            ValidationException::class => Response::HTTP_BAD_REQUEST,
            UnauthorizedException::class => Response::HTTP_FORBIDDEN,
        ];
    }

    protected function exceptionDetail(\Exception $error): string
    {
        if ($error instanceof ValidationException) {
            return 'The given data was invalid.';
        }

        if ($error instanceof UnauthorizedException) {
            return 'You do not have permission to view this resource.';
        }

        return parent::exceptionDetail($error);
    }
}
