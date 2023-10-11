<?php

namespace Modules\Admin\Tests\Feature;

use Modules\Admin\Models\WidgetVariable;
use Modules\Admin\Tests\AdminTestCase;

class WidgetVariableTest extends AdminTestCase
{

    public function testItUpdatesSuccessfully(): void
    {
        $value = $this->faker->randomNumber(9, false);
        $variable = WidgetVariable::getInsuranceFund();
        $this->putJson("/admin/widget-variable/$variable->id", [
            'value' => $value,
        ])->assertRedirect();

        self::assertEquals($variable->fresh()->value, $value);
    }
}
