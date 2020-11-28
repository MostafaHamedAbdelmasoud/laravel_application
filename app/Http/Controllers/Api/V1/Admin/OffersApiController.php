<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreOfferRequest;
use App\Http\Requests\UpdateOfferRequest;
use App\Http\Resources\Admin\OfferResource;
use App\Models\Offer;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OffersApiController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        $offerQueryBuilder = Offer::with(['category', 'trader']);
        //abort_if(Gate::denies('offer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $category_id = $request['category_id'];
        $trader_id = $request['trader_id'];


        if(isset($trader_id))
            $offerQueryBuilder = $offerQueryBuilder->where('trader_id',$trader_id);
        if(isset($category_id))
            $offerQueryBuilder = $offerQueryBuilder->where('category_id',$category_id);


        return new OfferResource($offerQueryBuilder->orderBy('created_at', 'desc')->get());
    }

    public function store(StoreOfferRequest $request)
    {
        $offer = Offer::create($request->all());

        if ($request->input('images', false)) {
            $offer->addMedia(storage_path('tmp/uploads/' . $request->input('images')))->toMediaCollection('images');
        }

        return (new OfferResource($offer))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Offer $offer)
    {
        //abort_if(Gate::denies('offer_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new OfferResource($offer->load(['category', 'trader']));
    }

    public function update(UpdateOfferRequest $request, Offer $offer)
    {
        $offer->update($request->all());

        if ($request->input('images', false)) {
            if (!$offer->images || $request->input('images') !== $offer->images->file_name) {
                if ($offer->images) {
                    $offer->images->delete();
                }

                $offer->addMedia(storage_path('tmp/uploads/' . $request->input('images')))->toMediaCollection('images');
            }
        } elseif ($offer->images) {
            $offer->images->delete();
        }

        return (new OfferResource($offer))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Offer $offer)
    {
        //abort_if(Gate::denies('offer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $offer->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
