<?php

namespace Modules\ClientApi\Tests\Feature;

use Modules\ClientApi\Database\Factories\UserFactory;
use Modules\ClientApi\Models\User;
use Modules\ClientApi\Tests\ClientApiTestCase;

class RegisterTest extends ClientApiTestCase
{

    public function testSuccess(): void
    {
        $email = $this->faker->email;

        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $email,
            'password' => UserFactory::STRONG_PASSWORD,
            'password_confirmation' => UserFactory::STRONG_PASSWORD,
        ];

        $this->postJson('api/v1/register', $data)->assertOk();

        unset($data['password_confirmation']);
        unset($data['password']);
        $data['email_verified_at'] = null;

        $this->assertDatabaseHas('users', $data);
    }

    public function testWrongData(): void
    {
        $data = [
            'first_name' => 1337,
            'last_name' => 1337,
            'email' => $this->faker->word,
            'password' => $this->faker->word,
            'password_confirmation' => $this->faker->word,
        ];

        $this->postJson('api/v1/register', $data)
            ->assertUnprocessable()
            ->assertInvalid([
                'email', 'password', 'first_name', 'last_name',
            ]);

        unset($data['password_confirmation']);
        unset($data['password']);

        $this->assertDatabaseMissing('users', $data);
    }

    public function testPasswordNotConfirmed(): void
    {
        $data = [
            'name' => $this->faker->firstNameFemale,
            'email' => $this->faker->email,
            'password' => UserFactory::STRONG_PASSWORD,
        ];

        $this->postJson('api/v1/register', $data)
            ->assertUnprocessable()
            ->assertInvalid(['password']);

        unset($data['password']);


        $this->assertDatabaseMissing('users', $data);
    }

    public function testAssertFieldsRequired(): void
    {
        $count = User::count();
        $this->postJson('api/v1/register')
            ->assertUnprocessable()
            ->assertInvalid([
                'first_name',
                'last_name',
                'email',
                'password',
            ]);

        self::assertSame($count, User::count());
    }
}
