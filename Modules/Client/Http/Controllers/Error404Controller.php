<?php

namespace Modules\Client\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;

class Error404Controller extends BaseClientController
{

    public function __invoke(): Renderable
    {
        return $this->view('404');
    }

}
