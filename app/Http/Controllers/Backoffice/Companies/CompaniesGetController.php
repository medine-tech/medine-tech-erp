<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backoffice\Companies;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use MedineTech\Backoffice\Companies\Application\Search\CompaniesSearcher;
use MedineTech\Backoffice\Companies\Application\Search\CompaniesSearcherRequest;
use MedineTech\Backoffice\Companies\Application\Search\CompanySearcherResponse;
use function Lambdish\Phunctional\map;

final class CompaniesGetController extends Controller
{
    public function __construct(
        private readonly CompaniesSearcher $searcher
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $filters = (array)$request->query();
            $filters["userId"] = $request->user()->id;
            $response = ($this->searcher)(new CompaniesSearcherRequest($filters));
            return response()->json([
                'items' => map(function (CompanySearcherResponse $response) {
                    return [
                        'id' => $response->id(),
                        'name' => $response->name(),
                    ];
                }, $response->items()),
                'total' => $response->total(),
                'per_page' => $response->perPage(),
                'current_page' => $response->currentPage(),
            ]);
        } catch (Exception $e) {
            return response()->json([
                "title" => "Internal Server Error",
                "detail" => "An unexpected error occurred",
                "error" => $e->getMessage(),
                "status" => 500,
            ], 500);
        }
    }
}
