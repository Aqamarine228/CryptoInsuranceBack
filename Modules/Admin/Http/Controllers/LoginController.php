<?php

namespace Modules\Admin\Http\Controllers;

use http\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\Components\Messages;

class LoginController extends BaseAdminController
{
    public function login()
    {
        if (Auth::guard('admin')->check()) {
            return redirect(route('admin.dashboard'));
        }
        return $this->view('login');
    }

    public function submitLogin(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email'=> 'email|required',
            'password' => 'required'
        ]);

        if (auth()->guard('admin')->attempt($validated)) {
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');
        }

        Messages::error('Wrong credentials');

        return redirect('admin.login');
    }
}
