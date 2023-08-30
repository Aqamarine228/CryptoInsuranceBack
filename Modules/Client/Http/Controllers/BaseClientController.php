<?php

namespace Modules\Client\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;

class BaseClientController extends Controller
{

    protected function view(string $view, array $data = []): Renderable
    {
        return view("client::$view", $data);
    }
}
