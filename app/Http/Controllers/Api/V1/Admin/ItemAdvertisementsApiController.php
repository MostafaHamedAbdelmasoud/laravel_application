<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreItemAdvertisementRequest;
use App\Http\Requests\UpdateItemAdvertisementRequest;
use App\Http\Resources\Admin\ItemAdvertisementResource;
use App\Models\ItemAdvertisement;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ItemAdvertisementsApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        //abort_if(Gate::denies('advertisement_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ItemAdvertisementResource(ItemAdvertisement::all());
    }

    public function store(StoreItemAdvertisementRequest $request)
    {
        $item_advertisement = ItemAdvertisement::create($request->all());

        if ($request->input('images', false)) {
            $item_advertisement->addMedia(storage_path('tmp/uploads/' . $request->input('images')))->toMediaCollection('images');
        }

        return (new ItemAdvertisementResource($item_advertisement))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show($item_advertisement)
    {
        //abort_if(Gate::denies('advertisement_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ItemAdvertisementResource(ItemAdvertisement::findOrFail($item_advertisement));
    }

    public function update(UpdateItemAdvertisementRequest $request, ItemAdvertisement $item_advertisement)
    {
        $item_advertisement->update($request->all());

        if ($request->input('images', false)) {
            if (!$item_advertisement->images || $request->input('images') !== $item_advertisement->images->file_name) {
                if ($item_advertisement->images) {
                    $item_advertisement->images->delete();
                }

                $item_advertisement->addMedia(storage_path('tmp/uploads/' . $request->input('images')))->toMediaCollection('images');
            }
        } elseif ($item_advertisement->images) {
            $item_advertisement->images->delete();
        }

        return (new ItemAdvertisementResource($item_advertisement))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ItemAdvertisement $item_advertisement)
    {
        //abort_if(Gate::denies('advertisement_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $item_advertisement->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
