<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backoffice\Accounting\AccountingCenters;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use MedineTech\Backoffice\Accounting\AccountingCenter\Application\Search\AccountingCentersSearcher;
use MedineTech\Backoffice\Accounting\AccountingCenter\Application\Search\AccountingCentersSearcherRequest;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Get(
 *     path="/api/backoffice/{tenant}/accounting/accounting-centers",
 *     summary="Search accounting centers based on filters",
 *     tags={"Backoffice - Accounting - Accounting Centers"},
 *     security={
 *         {"bearerAuth": {}}
 *     },
 *     @OA\Parameter(
 *         name="tenant",
 *         in="path",
 *         required=true,
 *         description="The tenant ID",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="page",
 *         in="query",
 *         description="Page number for pagination",
 *         required=false,
 *         @OA\Schema(
 *             type="integer",
 *             minimum=1
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful retrieval of accounting centers list",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="items", type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="string", example="1"),
 *                     @OA\Property(property="code", type="string", example="ACC-01"),
 *                     @OA\Property(property="name", type="string", example="Main Accounting Center"),
 *                     @OA\Property(property="description", type="string", example="Description of the Accounting Center"),
 *                     @OA\Property(property="status", type="string", example="ACTIVE"),
 *                     @OA\Property(property="parentId", type="string", nullable=true, example="NULL"),
 *                     @OA\Property(property="creatorId", type="integer", example=1),
 *                     @OA\Property(property="updaterId", type="integer", example=1),
 *                     @OA\Property(property="companyId", type="string", example="COMPANY-UUID")
 *                 )
 *             ),
 *             @OA\Property(property="total", type="integer", example=100),
 *             @OA\Property(property="per_page", type="integer", example=10),
 *             @OA\Property(property="current_page", type="integer", example=1)
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
 *         description="Internal Server Error",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="title", type="string", example="Internal Server Error"),
 *             @OA\Property(property="detail", type="string", example="An unexpected error occurred"),
 *             @OA\Property(property="status", type="integer", example=500)
 *         )
 *     )
 * )
 */
final class AccountingCentersGetController extends ApiController
{
    public function __construct(
        private readonly AccountingCentersSearcher $searcher
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        return $this->execute(function () use ($request) {
            $filters = (array)$request->query();
            $filters["companyId"] = tenant("id");

            $searcherRequest = new AccountingCentersSearcherRequest($filters);
            $searcherResponse = ($this->searcher)($searcherRequest);

            $centers = array_map(function ($center) {
                return [
                    "id" => $center->id(),
                    "code" => $center->code(),
                    "name" => $center->name(),
                    "description" => $center->description(),
                    "status" => $center->status(),
                    "parentId" => $center->parentId(),
                    "creatorId" => $center->creatorId(),
                    "updaterId" => $center->updaterId(),
                    "companyId" => $center->companyId(),
                ];
            }, $searcherResponse->items());

            return new JsonResponse([
                "items" => $centers,
                "total" => $searcherResponse->total(),
                "per_page" => $searcherResponse->perPage(),
                "current_page" => $searcherResponse->currentPage()
            ], Response::HTTP_OK);
        });
    }

    protected function exceptions(): array
    {
        return [
            UnauthorizedException::class => Response::HTTP_FORBIDDEN,
        ];
    }

    protected function exceptionDetail(\Exception $error): string
    {
        if ($error instanceof UnauthorizedException) {
            return 'You do not have permission to view this resource.';
        }

        return parent::exceptionDetail($error);
    }
}
