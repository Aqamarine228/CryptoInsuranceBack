<?php

namespace Modules\Client\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;

class HomeController extends BaseClientController
{

    public function __invoke(): Renderable
    {
        return $this->view('home');
    }
}
