<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ApiController;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller for handling password reset link requests
 */
class PasswordResetLinkController extends ApiController
{
    /**
     * @OA\Post(
     *     path="/api/forgot-password",
     *     summary="Send a password reset link to the given email",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"email"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Password reset link sent",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="We have emailed your password reset link!")
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
     *     )
     * )
     */
    public function store(Request $request): JsonResponse
    {
        return $this->execute(function () use ($request) {
            $request->validate([
                'email' => ['required', 'email'],
            ]);

            $status = Password::sendResetLink(
                $request->only('email')
            );

            if ($status != Password::RESET_LINK_SENT) {
                throw ValidationException::withMessages([
                    'email' => [__($status)],
                ]);
            }

            return new JsonResponse(['status' => __($status)], Response::HTTP_OK);
        });
    }

    /**
     * @return array<class-string, int>
     */
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
