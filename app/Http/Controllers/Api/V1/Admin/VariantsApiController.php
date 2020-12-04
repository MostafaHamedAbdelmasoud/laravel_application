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

    public function store(Product $product,Request $request)
    {
        $variant = Variant::create($request->all());

        $product_variant = ProductVariant::create([
            'product_id'=>$product->id,
            'variant_id'=>$variant->id,
        ]);

        if ($request->images) {
            $variant->addMedia($request->images)->toMediaCollection('image');
        }

        return (new VariantResource($variant))
            ->additional(['product_variants' => $product->ProductVariants])
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Product $product)
    {
        //abort_if(Gate::denies('product_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProductResource($product->load(['trader']));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $request['show_in_main_page']= $request->has('show_in_main_page')?1:0;

        $request['show_in_trader_page']= $request->has('show_in_trader_page')?1:0;

        $product->update($request->all());

        if ($request->input('image', false)) {
            if (!$product->image || $request->input('image') !== $product->image->file_name) {
                if ($product->image) {
                    $product->image->delete();
                }

                $product->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->toMediaCollection('image');
            }
        } elseif ($product->image) {
            $product->image->delete();
        }

        return (new ProductResource($product))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Product $product)
    {
        //abort_if(Gate::denies('product_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $product->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
