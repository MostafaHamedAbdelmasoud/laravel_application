<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNotificationRequest;
use App\Http\Requests\UpdateNotificationRequest;
use App\Http\Resources\Admin\NotificationResource;
use App\Models\Notification;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NotificationsApiController extends Controller
{
    public function index()
    {
        //abort_if(Gate::denies('notification_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new NotificationResource(Notification::all());
    }

    public function store(StoreNotificationRequest $request)
    {
        $notifications = [];
        foreach ($request->city_id as $city_id) {
            $notifications[] = Notification::create(
                array_merge($request->except('city_id'), ['city_id' => $city_id])
            );
        }

        return (new NotificationResource($notifications))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Notification $notification)
    {
        //abort_if(Gate::denies('notification_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new NotificationResource($notification);
    }

    public function update(UpdateNotificationRequest $request, Notification $notification)
    {
        $notifications = [];
        foreach ($request->city_id as $city_id) {
            $notifications[] = Notification::update(
                array_merge($request->except('city_id'), ['city_id' => $city_id])
            );
        }
        return (new NotificationResource($notifications))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Notification $notification)
    {
        //abort_if(Gate::denies('notification_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $notification->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
