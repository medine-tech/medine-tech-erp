<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class AuthenticatedSessionController extends ApiController
{
    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Authenticate user and return token",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="email", type="string", example="user@example.com"),
     *             @OA\Property(property="password", type="string", example="password")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful authentication",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="token", type="string", example="your_token_here"),
     *             @OA\Property(property="default_company_id", type="string", example="123e4567-e89b-12d3-a456-426614174000")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="title", type="string", example="Validation Error"),
     *             @OA\Property(property="status", type="integer", example=422),
     *             @OA\Property(property="detail", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid credentials",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="title", type="string", example="Unauthorized"),
     *             @OA\Property(property="status", type="integer", example=401),
     *             @OA\Property(property="detail", type="string", example="Invalid credentials")
     *         )
     *     )
     * )
     */
    public function store(LoginRequest $request): JsonResponse
    {
        return $this->execute(function () use ($request) {
            $request->authenticate();

            $user = User::where('email', $request->email)->first();

            $token = $user->createToken('api-token')->plainTextToken;
            $defaultCompanyId = (string)$user->default_company_id;

            return new JsonResponse([
                'token' => $token,
                'default_company_id' => $defaultCompanyId,
            ], Response::HTTP_OK);
        });
    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Logout user and invalidate token",
     *     tags={"Authentication"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful logout",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Logged out")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="title", type="string", example="Unauthorized"),
     *             @OA\Property(property="status", type="integer", example=401),
     *             @OA\Property(property="detail", type="string", example="Unauthenticated")
     *         )
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function destroy(Request $request): JsonResponse
    {
        return $this->execute(function () use ($request) {
            $request->user()->currentAccessToken()->delete();

            return new JsonResponse(['message' => 'Logged out'], Response::HTTP_OK);
        });
    }

    protected function exceptions(): array
    {
        return [
            ValidationException::class => Response::HTTP_UNPROCESSABLE_ENTITY,
        ];
    }

    protected function exceptionDetail(Exception $error): string
    {
        if ($error instanceof ValidationException) {
            return 'The given data was invalid.';
        }

        return parent::exceptionDetail($error);
    }
}
