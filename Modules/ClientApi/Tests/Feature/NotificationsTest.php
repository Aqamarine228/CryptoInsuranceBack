<?php

namespace Modules\ClientApi\Tests\Feature;

use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Testing\Fluent\AssertableJson;
use Modules\ClientApi\Database\Factories\DatabaseNotificationFactory;
use Modules\ClientApi\Http\Resources\DatabaseNotificationResource;
use Modules\ClientApi\Notifications\VerifyEmailNotification;
use Modules\ClientApi\Tests\ClientApiTestCase;

class NotificationsTest extends ClientApiTestCase
{
    public function testItReturnsCorrectResult(): void
    {
        DatabaseNotificationFactory::new()->state([
            'notifiable_id' => $this->user->id,
            'data' => ['message_text_key' => 'welcome'],
            'type' => VerifyEmailNotification::class,
        ])->count(10)->create();
        $this->getJson('/api/v1/notifications')->assertStatus(200)->assertJson(
            fn (AssertableJson $json) => $json
                ->where('success', true)
                ->where(
                    'response',
                    DatabaseNotificationResource::collection(
                        $this->user->notifications()->get()
                    )->response()->getData(true)['data']
                )
        );
    }

    public function testItMarksNotificationsAsRead(): void
    {
        $notifications = DatabaseNotificationFactory::new()->state([
            'notifiable_id' => $this->user->id,
            'read_at' => null,
        ])->count(10)->create();

        $this->postJson('/api/v1/notifications/mark-as-read', [
            'notifications' => $notifications->pluck('id')
        ])->assertStatus(200);

        self::assertFalse(
            DatabaseNotification::whereIn('id', $notifications->pluck('id'))
                ->whereNull('read_at')
                ->exists()
        );
    }

    public function testItDeletesNotifications(): void
    {
        $notification = DatabaseNotificationFactory::new()
            ->count(10)
            ->state(['notifiable_id' => $this->user->id])
            ->create();

        $this
            ->deleteJson("/api/v1/notifications", ['notifications' => $notification->pluck('id')])
            ->assertStatus(200);

        self::assertFalse(DatabaseNotification::whereIn('id', $notification->pluck('id'))->exists());
    }
}
