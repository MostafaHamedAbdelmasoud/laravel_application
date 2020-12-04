<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;
use App\Http\Resources\Admin\CouponResource;
use App\Models\Coupon;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CouponsApiController extends Controller
{
    public function index(Request $request)
    {
        return new CouponResource(Coupon::all());
    }

    public function store(StoreCouponRequest $request)
    {
        $coupon = Coupon::create($request->all());

        return (new CouponResource($coupon))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Coupon $coupon)
    {
        //abort_if(Gate::denies('coupon_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CouponResource($coupon);
    }

    public function update(UpdateCouponRequest $request, Coupon $coupon)
    {
        $coupon->update($request->all());

        return (new CouponResource($coupon))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Coupon $coupon)
    {
        //abort_if(Gate::denies('coupon_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $coupon->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
