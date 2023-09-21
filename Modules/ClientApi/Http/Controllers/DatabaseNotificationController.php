<?php

namespace Modules\ClientApi\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\ClientApi\Http\Resources\DatabaseNotificationResource;
use Modules\ClientApi\Models\DatabaseNotification;

class DatabaseNotificationController extends BaseClientApiController
{
    public function index(Request $request): JsonResponse
    {
        return $this->respondSuccess(
            DatabaseNotificationResource::collection(
                $request->user()->notifications
            )
        );
    }

    public function show(DatabaseNotification $databaseNotification): JsonResponse
    {
        return $this->respondSuccess(new DatabaseNotificationResource($databaseNotification));
    }

    public function markAsRead(Request $request): JsonResponse
    {
        $request->user()->unreadNotifications->markAsRead();

        return $this->respondSuccess("Notifications marked as read successfully");
    }

    public function destroy(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'notifications' => 'required|array',
            'notifications.*' => 'required|exists:notifications,id,notifiable_id,'
                . $request->user()->id
                . ",notifiable_type,"
                . User::class,
        ]);

        $request->user()->notifications()->whereIn('id', $validated['notifications'])->delete();

        return $this->respondSuccess("Notifications deleted successfully");
    }
}
