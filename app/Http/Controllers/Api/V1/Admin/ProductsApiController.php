<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Filters\ProductsFilter;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\Admin\ProductResource;
use App\Models\Product;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductsApiController extends Controller
{
    use MediaUploadingTrait;

    /**
     * @var ProductsFilter
     */
    private $filter;

    public function __construct(ProductsFilter $filter)
    {
        $this->filter = $filter;
    }

    public function index(Request $request)
    {
        //abort_if(Gate::denies('product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $productQuery = Product::filter($this->filter)->with('trader');

        $trader_id = $request['trader_id'];

        $main_product_type_id = $request['main_product_type_id'];

        $main_product_service_type_id = $request['main_product_service_type_id'];

        $sub_product_type_id = $request['sub_product_type_id'];

        $sub_product_service_type_id = $request['sub_product_service_type_id'];

        $details = $request['details'];

        if (isset($details)) {
            $productQuery = $productQuery->where('details', 'like', "%$details%");
        }
        if (isset($sub_product_service_type_id)) {
            $productQuery = $productQuery->where('sub_product_service_type_id', $sub_product_service_type_id);
        }
        if (isset($sub_product_type_id)) {
            $productQuery = $productQuery->where('sub_product_type_id', $sub_product_type_id);
        }
        if (isset($main_product_service_type_id)) {
            $productQuery = $productQuery->where('main_product_service_type_id', $main_product_service_type_id);
        }
        if (isset($main_product_type_id)) {
            $productQuery = $productQuery->where('main_product_type_id', $main_product_type_id);
        }
        if (isset($trader_id)) {
            $productQuery = $productQuery->where('trader_id', $trader_id);
        }
        return new ProductResource($productQuery->latest()->get());
    }

    public function store(StoreProductRequest $request)
    {
        $request['show_in_main_page'] = $request->has('show_in_main_page') ? 1 : 0;

        $request['show_in_trader_page'] = $request->has('show_in_trader_page') ? 1 : 0;

        $product = Product::create($request->all());

        if ($request->input('image', false)) {
            $product->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->toMediaCollection('image');
        }

        return (new ProductResource($product))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show($product)
    {
        //abort_if(Gate::denies('product_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProductResource(Product::findOrFail($product));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $request['show_in_main_page'] = $request->has('show_in_main_page') ? 1 : 0;

        $request['show_in_trader_page'] = $request->has('show_in_trader_page') ? 1 : 0;

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
