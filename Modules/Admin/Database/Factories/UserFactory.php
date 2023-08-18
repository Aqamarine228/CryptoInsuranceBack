<?php

namespace Modules\Admin\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Modules\Admin\Models\User;

class UserFactory extends Factory
{

    protected $model = User::class;

    const STRONG_PASSWORD = 'B3stPa$sword1337!';

    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt(self::STRONG_PASSWORD),
            'locale' => locale()->default(),
        ];
    }

    public function password(string $password): static
    {
        return $this->state(function () use ($password) {
            return [
                'password' => Hash::make($password),
            ];
        });
    }
}
