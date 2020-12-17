<?php

use App\Models\ProductVariant ;
use App\Models\Variant;
use Illuminate\Database\Seeder;

class ProductVariantTableSeeder extends Seeder
{
    public function run()
    {
        $products_variants = [
            [
                'id'             => 1,
                'product_id'           => '1',
                'variant_id'          => '1',
            ],
        ];

        ProductVariant::insert($products_variants);
    }
}
