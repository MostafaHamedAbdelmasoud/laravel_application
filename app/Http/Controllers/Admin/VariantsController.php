<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Variant;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class VariantsController extends Controller
{
    use MediaUploadingTrait;

    public function index(Product $product, Request $request)
    {
        //abort_if(Gate::denies('variant_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Variant::whereHas('products', function ($q) use ($product) {
                $q->where('product_id', $product->id);
            })->select(sprintf('%s.*', (new Variant)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) use ($product) {
                $viewGate = 'product_show';
                $editGate = 'product_edit';
                $deleteGate = 'product_delete';
                $crudRoutePart = 'products.variants';
                $parent = $product;

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row',
                    'parent'
                ));
            });

            $table->editColumn('id', function ($row) use ($product) {
                return $row->id ? $row->id : "";
            });
            $table->editColumn('color', function ($row) use ($product) {
                return $row->color ? $row->color : "";
            });
            $table->editColumn('size', function ($row) use ($product) {
                return $row->size ? $row->size : "";
            });
            $table->editColumn('price', function ($row) use ($product) {
                return $row->price ? $row->price : "";
            });
            $table->editColumn('count', function ($row) use ($product) {
                return $row->count ? $row->count : "";
            });
            $table->editColumn('image', function ($row) use ($product) {
                if ($photo = $row->image) {
                    return sprintf(
                        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
                        $photo->url,
                        $photo->thumbnail
                    );
                }
                return '';
            });

            $table->rawColumns(['actions', 'placeholder', 'image']);

                 
            return $table->make(true);
        }


        return view('admin.variants.index', compact('product'));
    }

    public function create(Product $product)
    {
        //abort_if(Gate::denies('variant_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.variants.create', compact('product'));
    }

    public function store(Product $product, Request $request)
    {
        try {
            $variant = $product->variants()->create($request->all());

            if ($request->input('image', false)) {
                $variant->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->toMediaCollection('image');
            }

            if ($media = $request->input('ck-media', false)) {
                Media::whereIn('id', $media)->update(['model_id' => $variant->id]);
            }


            return redirect()->route('admin.products.variants.index', $product);
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
    }

    public function edit(Product $product, Variant $variant)
    {
        //abort_if(Gate::denies('variant_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.variants.edit', compact('product', 'variant'));
    }

    public function update(Product $product, Request $request, Variant $variant)
    {
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

        return redirect()->route('admin.products.variants.show', [$product, $variant]);
    }

    public function show(Product $product, Variant $variant)
    {
        //abort_if(Gate::denies('variant_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.variants.show', compact('variant', 'product'));
    }

    public function destroy(Product $product, Variant $variant)
    {
        //abort_if(Gate::denies('variant_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        // $product_variants = ProductVariant::where('variant_id', $variant->id)->get();
        // foreach ($product_variants as $product_variant) {
        //     $product_variant->delete();
        // }
        $product->variants()->detach($variant->id);

        $variant->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        $product_variants = ProductVariant::whereIn('variant_id', request('ids'))->get();
        foreach ($product_variants as $product_variant) {
            $product_variant->delete();
        }
        Variant::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        //abort_if(Gate::denies('variant_create') && Gate::denies('variant_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model = new Variant();
        $model->id = $request->input('crud_id', 0);
        $model->exists = true;
        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
