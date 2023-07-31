<?php

namespace Modules\ClientApi\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\ClientApi\Models\DatabaseNotification;
use App\Models\User;

class DatabaseNotificationFactory extends Factory
{
    protected $model = DatabaseNotification::class;

    public function definition(): array
    {
        return [
            'id' => Str::uuid(),
            'type' => 'user_text_notification',
            'notifiable_type' => User::class,
            'notifiable_id' => UserFactory::new()->create()->id,
            'data' => ['message_text_key' => 'welcome'],
            'read_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
