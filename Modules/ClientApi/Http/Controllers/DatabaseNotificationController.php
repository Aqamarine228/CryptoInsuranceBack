<?php

namespace Modules\ClientApi\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\ClientApi\Http\Resources\DatabaseNotificationResource;

class DatabaseNotificationController extends BaseClientApiController
{
    public function index(Request $request): JsonResponse
    {
        return $this->respondSuccess(
            DatabaseNotificationResource::collection(
                $request->user()->notifications()->paginate(5)
            )->response()->getData(true)
        );
    }

    public function markAsRead(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'notifications' => 'required|array',
            'notifications.*' => 'required|exists:notifications,id,notifiable_id,'
                . $request->user()->id
                . ",notifiable_type,"
                . User::class,
        ]);
        $request->user()->notifications()->whereIn('id', $validated['notifications'])->get()->markAsRead();

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
