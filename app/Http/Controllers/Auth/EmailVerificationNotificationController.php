<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Email verification notification controller
 */
class EmailVerificationNotificationController extends ApiController
{
    /**
     * @OA\Post(
     *     path="/api/email/verification-notification",
     *     summary="Send a new email verification notification",
     *     tags={"Authentication"},
     *     @OA\Response(
     *         response=200,
     *         description="Verification link sent",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="verification-link-sent")
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
    public function store(Request $request): JsonResponse
    {
        return $this->execute(function () use ($request) {
            if ($request->user()->hasVerifiedEmail()) {
                return new JsonResponse(['status' => 'already-verified'], Response::HTTP_OK);
            }

            $request->user()->sendEmailVerificationNotification();

            return new JsonResponse(['status' => 'verification-link-sent'], Response::HTTP_OK);
        });
    }
}
