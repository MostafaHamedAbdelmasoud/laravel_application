<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreTraderRequest;
use App\Http\Requests\UpdateTraderRequest;
use App\Http\Resources\Admin\TraderResource;
use App\Models\Trader;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TraderApiController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        //abort_if(Gate::denies('trader_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $traderQuery =  Trader::with('products');
        $details = $request['details'];
        if (isset($details)) {
            $traderQuery = $traderQuery->where('details', 'like', "%$details%");
        }
        return new TraderResource($traderQuery->get());
    }

    public function store(StoreTraderRequest $request)
    {
        $trader = Trader::create($request->all());

        if ($request->input('images', false)) {
            $trader->addMedia(storage_path('tmp/uploads/' . $request->input('images')))->toMediaCollection('images');
        }

        return (new TraderResource($trader))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show($trader)
    {
        //abort_if(Gate::denies('trader_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TraderResource(Trader::findOrFail($trader));
    }

    public function update(UpdateTraderRequest $request, Trader $trader)
    {
        $trader->update($request->all());

        if ($request->input('images', false)) {
            if (!$trader->images || $request->input('images') !== $trader->images->file_name) {
                if ($trader->images) {
                    $trader->images->delete();
                }

                $trader->addMedia(storage_path('tmp/uploads/' . $request->input('images')))->toMediaCollection('images');
            }
        } elseif ($trader->images) {
            $trader->images->delete();
        }

        return (new TraderResource($trader))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Trader $trader)
    {
        //abort_if(Gate::denies('trader_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $trader->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
