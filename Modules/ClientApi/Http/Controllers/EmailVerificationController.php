<?php

namespace Modules\ClientApi\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\ClientApi\Models\User;

class EmailVerificationController extends BaseClientApiController
{
    public function resendVerificationEmail(Request $request): JsonResponse
    {
        $request->user()->sendEmailVerificationNotification();

        return $this->respondSuccess("Verification link was sent successfully");
    }

    public function verify(Request $request): JsonResponse
    {
        $user = User::find($request->route('id'));

        if (!$user) {
            return $this->respondErrorMessage(__("errors.badUser"));
        }

        if (! hash_equals(sha1($user->getEmailForVerification()), (string) $request->route('hash'))) {
            throw new AuthorizationException;
        }

        if ($user->hasVerifiedEmail()) {
            return $this->respondErrorMessage("Email already verified");
        }

        $user->markEmailAsVerified();


        return $this->respondSuccess("Email verified successfully");
    }
}
