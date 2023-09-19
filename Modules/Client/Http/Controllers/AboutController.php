<?php

namespace Modules\Client\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;

class AboutController extends BaseClientController
{

    public function __invoke(): Renderable
    {
        return $this->view('about.about');
    }

}
