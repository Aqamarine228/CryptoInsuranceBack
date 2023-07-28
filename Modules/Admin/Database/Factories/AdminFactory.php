<?php

namespace Modules\Admin\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Modules\Admin\Models\Admin;

class AdminFactory extends Factory
{

    protected $model = Admin::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->firstName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make($this->faker->password),
        ];
    }
}
