<?php

namespace Modules\Client\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Modules\Client\Emails\ContactMail;

class ContactController extends BaseClientController
{

    public function index(): Renderable
    {
        return $this->view('contact');
    }

    public function submitForm(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'nullable',
            'subject' => 'required',
            'text' => 'required'
        ]);

        Mail::to(config('mail.support_email'))->send(new ContactMail(...$validated));

        return redirect()->back();
    }

}
