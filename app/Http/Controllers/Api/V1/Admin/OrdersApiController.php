<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\Admin\OrderResource;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderProduct;
use Exception;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class OrdersApiController extends Controller
{
    public function index()
    {
        //abort_if(Gate::denies('Order_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new OrderResource(Order::with('OrderProducts')->get());
    }


    public function store(StoreOrderRequest $request)
    {
        DB::beginTransaction();
//        try {
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $request['user_id'] = $user_id;
        } else {
            return 'لا يوجد مستخدم للطلب';
        }

        if ($request->coupon_id) {
            $coupon = Coupon::findOrFail( $request->coupon_id);
            if (!$coupon || $coupon->max_usage_per_user <= 0) {
                return response()->json([
                    'message' => 'الكوبون غير صالح!'
                ]);
            } else {
                $coupon->update([
                    'max_usage_per_user' => $coupon->max_usage_per_user - 1
                ]);

            }
        }

        $order = Order::create($request->all());


        foreach ($request->order_products as $order_product) {
            OrderProduct::create([

                'product_variant_id' => $order_product['product_variant_id'],

                'order_id' => $order->id,
                // todo
                'quantity' => $order_product['quantity'],
            ]);
        }

        DB::commit();

        return (new OrderResource($order->load(['coupon', 'OrderProducts'])))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
//        } catch (Exception $e) {
//            DB::rollback();
//
//            return ($e->getMessage());
//        }
    }

    public function show($order)
    {
        //abort_if(Gate::denies('Order_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new OrderResource(Order::findOrFail($order)->load(['OrderProducts']));
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        $order->update($request->all());

        $order_product_ids = $order->OrderProducts->pluck('id');

        foreach ($order_product_ids as $id) {
            OrderProduct::where('id', $id)->delete();
        }

        foreach ($request->product_variant as $id) {
            $order->OrderProducts()->create([
                'product_variant_id' => $id,
            ]);
        }

        return (new OrderResource($order))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Order $Order)
    {
        //abort_if(Gate::denies('Order_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $Order->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
