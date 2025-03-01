<?php

namespace App\Http\Controllers\Backoffice\FirstCompanies;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use MedineTech\Backoffice\FirstCompanies\Application\Register\FirstCompanyRegister;
use MedineTech\Backoffice\FirstCompanies\Application\Register\FirstCompanyRegisterRequest;

/**
 * @OA\Post(
 *     path="/api/backoffice/first-companies",
 *     summary="Register the first company with an admin user",
 *     tags={"Backoffice - First Companies"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             required={"name", "email", "password", "password_confirmation"},
 *             @OA\Property(property="name", type="string", example="Company Name"),
 *             @OA\Property(property="email", type="string", example="admin@example.com"),
 *             @OA\Property(property="password", type="string", example="password"),
 *             @OA\Property(property="password_confirmation", type="string", example="password")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Company and admin user registered successfully"
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="title", type="string", example="Validation Error"),
 *             @OA\Property(property="details", type="string", example="The given data was invalid."),
 *             @OA\Property(property="status", type="integer", example=422),
 *             @OA\Property(property="errors", type="object")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Server error",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="title", type="string", example="Internal Server Error"),
 *             @OA\Property(property="details", type="string"),
 *             @OA\Property(property="status", type="integer", example=500)
 *         )
 *     )
 * )
 */
final class FirstCompanyPostController extends Controller
{
    public function __construct(
        private readonly FirstCompanyRegister $firstCompanyRegister,
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            ($this->firstCompanyRegister)(new FirstCompanyRegisterRequest(
                $validated['name'],
                $validated['email'],
                Hash::make($validated['password']),
            ));

            return response()->json();
        } catch (ValidationException $e) {
            return response()->json([
                "title" => "Validation Error",
                "details" => "The given data was invalid.",
                "status" => 422,
                "errors" => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                "title" => "Internal Server Error",
                "details" => $e->getMessage(),
                "status" => 500,
            ], 500);
        }
    }
}
