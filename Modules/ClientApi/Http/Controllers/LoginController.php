<?php

namespace Modules\ClientApi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Modules\ClientApi\Models\User;

class LoginController extends BaseClientApiController
{
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return $this->respondErrorMessage('The provided credentials are incorrect');
        }

        return $this->respondSuccess($user->createToken($user->email)->plainTextToken);
    }
}
