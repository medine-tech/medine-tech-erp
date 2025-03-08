<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backoffice\Companies;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CompaniesGetController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'page' => 'sometimes|integer|min:1',
        ]);

        $user = $request->user();

        try {
            $companies = $user->companies()->paginate(10);
            return response()->json([
                'status'  => 200,
                'message' => 'Success',
                'data'    => ['data' => $companies->items()],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 500,
                'message' => 'An error occurred',
                'data'    => ['data' => []],
            ], 500);
        }
    }
}
