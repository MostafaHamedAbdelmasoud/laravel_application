<?php


namespace App\Repositories;

use App\Models\Coupon;
use App\Models\Product;

class ProductRepository
{
    /**
     * create model
     *
     * @param Product $product
     * @return mixed
     */
    public function deleteRelatedFirst(Product $product)
    {
        $product_variants = $product->ProductVariants;
        foreach ($product_variants as $product_variant) {
            $medias = $product_variant->variant->media;
            dd($medias);
            foreach ($medias as $media) {
                $media->delete();
            }
            $product_variant->variant->delete();
            $product_variant->delete();
        }
//        dd($product->ProductVariants);
    }

    /**
     * Display the given client instance.
     *
     * @param mixed $model
     * @return Coupon
     */
    public function find($model)
    {
        if ($model instanceof Product) {
            return $model;
        }

        return Product::findOrFail($model);
    }


    /**
     * update model
     *
     * @param array $data
     * @return mixed
     */
    public function update($model, array $data)
    {
        $coupon = $this->find($model);

        if ($data['type'] == 'percentage_discount') {
            $data['fixed_discount'] = null;
        } else {
            $data['percentage_discount'] = null;
        }

        $coupon->update($data);

        return $coupon;
    }
}
