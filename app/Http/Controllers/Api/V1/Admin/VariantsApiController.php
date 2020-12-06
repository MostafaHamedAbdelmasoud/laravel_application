<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\Admin\ProductResource;
use App\Http\Resources\Admin\VariantResource;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Variant;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VariantsApiController extends Controller
{
    use MediaUploadingTrait;


    public function index(Product $variant)
    {
        //abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new VariantResource($variant->variants);
    }


    public function store(Product $variant, Request $request)
    {
        $variant = Variant::create($request->all());

        $variant_variant = ProductVariant::create([
            'product_id'=>$variant->id,
            'variant_id'=>$variant->id,
        ]);

        if ($request->images) {
            $variant->addMedia($request->images)->toMediaCollection('image');
        }

        return (new VariantResource($variant))
            ->additional(['product_variants' => $variant->variants])
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show( $variant)
    {
        //abort_if(Gate::denies('product_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProductResource(Product::findOrFail($variant)->load(['trader']));
    }

    public function update(UpdateProductRequest $request, Product $variant)
    {
        $request['show_in_main_page']= $request->has('show_in_main_page')?1:0;

        $request['show_in_trader_page']= $request->has('show_in_trader_page')?1:0;

        $variant->update($request->all());

        if ($request->input('image', false)) {
            if (!$variant->image || $request->input('image') !== $variant->image->file_name) {
                if ($variant->image) {
                    $variant->image->delete();
                }

                $variant->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->toMediaCollection('image');
            }
        } elseif ($variant->image) {
            $variant->image->delete();
        }

        return (new ProductResource($variant))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Product $variant)
    {
        //abort_if(Gate::denies('product_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $variant->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
