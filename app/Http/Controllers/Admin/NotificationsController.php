<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyNotificationRequest;
use App\Http\Requests\StoreNotificationRequest;
use App\Http\Requests\UpdateNotificationRequest;
use App\Models\City;
use App\Models\Notification;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NotificationsController extends Controller
{
    public function index()
    {
        //abort_if(Gate::denies('notification_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $notifications = Notification::all();

        return view('admin.notifications.index', compact('notifications'));
    }

    public function create()
    {
        //abort_if(Gate::denies('notification_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $cities = City::all();

        return view('admin.notifications.create', compact('cities'));
    }

    public function store(StoreNotificationRequest $request)
    {
        foreach ($request->city_id as $city_id) {
            Notification::create(
                array_merge($request->except('city_id'), ['city_id' => $city_id])
            );
        }
        return redirect()->route('admin.notifications.index');
    }

    public function edit(Notification $notification)
    {
        //abort_if(Gate::denies('notification_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.notifications.edit', compact('notification'));
    }

    public function update(UpdateNotificationRequest $request, Notification $notification)
    {
        $notification->update($request->all());

        return redirect()->route('admin.notifications.index');
    }

    public function show(Notification $notification)
    {
        //abort_if(Gate::denies('notification_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.notifications.show', compact('notification'));
    }

    public function destroy(Notification $notification)
    {
        //abort_if(Gate::denies('notification_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $notification->delete();

        return back();
    }

    public function massDestroy(MassDestroyNotificationRequest $request)
    {
        Notification::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
