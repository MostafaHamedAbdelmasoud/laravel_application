<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreAdvertisementRequest;
use App\Http\Requests\UpdateAdvertisementRequest;
use App\Http\Resources\Admin\AdvertisementResource;
use App\Models\Advertisement;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MainPageImagesApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        //abort_if(Gate::denies('advertisement_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AdvertisementResource(Advertisement::all());
    }

    public function store(StoreAdvertisementRequest $request)
    {
        $advertisement = Advertisement::create($request->all());

        if ($request->input('images', false)) {
            $advertisement->addMedia(storage_path('tmp/uploads/' . $request->input('images')))->toMediaCollection('images');
        }

        return (new AdvertisementResource($advertisement))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show($advertisement)
    {
        //abort_if(Gate::denies('advertisement_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AdvertisementResource(Advertisement::findOrFail($advertisement));
    }

    public function update(UpdateAdvertisementRequest $request, Advertisement $advertisement)
    {
        $advertisement->update($request->all());

        if ($request->input('images', false)) {
            if (!$advertisement->images || $request->input('images') !== $advertisement->images->file_name) {
                if ($advertisement->images) {
                    $advertisement->images->delete();
                }

                $advertisement->addMedia(storage_path('tmp/uploads/' . $request->input('images')))->toMediaCollection('images');
            }
        } elseif ($advertisement->images) {
            $advertisement->images->delete();
        }

        return (new AdvertisementResource($advertisement))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Advertisement $advertisement)
    {
        //abort_if(Gate::denies('advertisement_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $advertisement->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
