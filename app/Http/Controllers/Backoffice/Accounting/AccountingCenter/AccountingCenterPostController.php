<?php
declare(strict_types=1);

namespace App\Http\Controllers\Backoffice\Accounting\AccountingCenter;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use MedineTech\Backoffice\Accounting\AccountingCenter\Application\Create\AccountingCenterCreator;
use MedineTech\Backoffice\Accounting\AccountingCenter\Application\Create\AccountingCenterCreatorRequest;
use MedineTech\Backoffice\Accounting\AccountingCenter\Infrastructure\Authorization\AccountingCenterPermissions;
use Symfony\Component\HttpFoundation\JsonResponse;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
 *             @OA\Property(property="status", type="string", example="active", description="active or inactive"),
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
final class AccountingCenterPostController
{
    public function __construct(private readonly AccountingCenterCreator $creator)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
//            $user = $request->user();
//            Role::create(['name' => 'developer']);
//            Permission::create(['name' => AccountingCenterPermissions::CREATE]);
//
//            $role = Role::findByName('developer');
//            $permission = Permission::findByName(AccountingCenterPermissions::VIEW->value);
//            $role->syncPermissions([$permission]);
//            $user->syncRoles([$role->name]);

            if (!$request->user()->can(AccountingCenterPermissions::CREATE)) {
                throw new UnauthorizedException(403);
            }

            $validatedData = $request->validate([
                'id' => 'required|string|uuid',
                'code' => 'required|string|max:50',
                'name' => 'required|string|min:3|max:40',
                'description' => 'nullable|string',
                'status' => 'required|string|in:active,inactive',
                'parent_id' => 'nullable|string|uuid',
            ]);

            $userId = $request->user()->id;

            $creatorRequest = new AccountingCenterCreatorRequest(
                $validatedData['id'],
                $validatedData['code'],
                $validatedData['name'],
                $validatedData['description'] ?? null,
                $validatedData['status'],
                $validatedData['parent_id'] ?? null,
                $request->tenant('id'),
                $userId
            );

            ($this->creator)($creatorRequest);

            return new JsonResponse(null, JsonResponse::HTTP_CREATED);
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
        }
        catch (Exception $e) {
            return new JsonResponse([
                'title' => 'Internal Server Error',
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'detail' => 'An unexpected error occurred while processing your request.',
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
