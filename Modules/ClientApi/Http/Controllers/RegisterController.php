<?php

namespace Modules\ClientApi\Http\Controllers;

use App\Rules\StrongPasswordRule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\ClientApi\Models\User;

class RegisterController extends BaseClientApiController
{
    public function __invoke(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'inviter_id' => 'nullable|uuid|exists:users,referral_id',
            'first_name' => 'string|required|max:255',
            'last_name' => 'string|required|max:255',
            'email' => 'required|email|string|max:255|unique:users,email',
            'password' => ['required', 'string', 'confirmed', new StrongPasswordRule],
        ]);

        $user = User::create($validated);
        $user->sendEmailVerificationNotification();

        return $this->respondSuccess(
            $user->createToken($user->email)->plainTextToken
        );
    }
}
