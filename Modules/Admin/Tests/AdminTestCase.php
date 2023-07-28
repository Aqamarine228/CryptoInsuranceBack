<?php

namespace Modules\Admin\Tests;

use Modules\Admin\Database\Factories\AdminFactory;
use Modules\Admin\Models\Admin;
use Tests\TestCase;

class AdminTestCase extends TestCase
{
    protected Admin $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndSetDefaultAdmin();
    }

    private function createAndSetDefaultAdmin(): void
    {
        $this->admin = AdminFactory::new()->create();
        $this->actingAs($this->admin, 'admin');
    }
}
