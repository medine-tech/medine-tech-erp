<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ApiController;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller for verifying user email addresses
 */
class VerifyEmailController extends ApiController
{
    /**
     * @OA\Get(
     *     path="/api/verify-email/{id}/{hash}",
     *     summary="Verify user email address",
     *     tags={"Authentication"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="User ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="hash",
     *         in="path",
     *         required=true,
     *         description="Email verification hash",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Email verified successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="verified"),
     *             @OA\Property(property="message", type="string", example="Email verified successfully")
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
    public function __invoke(EmailVerificationRequest $request): JsonResponse
    {
        return $this->execute(function () use ($request) {

            /** @var MustVerifyEmail $user */
            $user = $request->user();

            if ($user->hasVerifiedEmail()) {
                return new JsonResponse([
                    'status' => 'verified',
                    'message' => 'Email already verified'
                ], Response::HTTP_OK);
            }

            if ($user->markEmailAsVerified()) {
                event(new Verified($user));
            }

            return new JsonResponse([
                'status' => 'verified',
                'message' => 'Email verified successfully'
            ], Response::HTTP_OK);
        });
    }
}
