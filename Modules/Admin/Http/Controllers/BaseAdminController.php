<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BaseAdminController extends Controller
{
    protected function view(string $name, array $data = []): Renderable
    {
        return view("admin::$name", $data);
    }
}
