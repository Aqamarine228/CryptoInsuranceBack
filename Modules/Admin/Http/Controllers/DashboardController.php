<?php

namespace Modules\Admin\Http\Controllers;

class DashboardController extends BaseAdminController
{

    public function __invoke()
    {
        return $this->view('dashboard');
    }
}
