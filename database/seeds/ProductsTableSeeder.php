<?php

use App\Models\Variant;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'id'             => 1,
                'name'             => 'product 1',
                'brand'             => 'adidas',
                'detailed_title'             => 'hello there',
                'details'             => 'details details details',
                'price_after_discount'             => '13',
                'product_code'             => 'XCD233',
                'show_trader_name'             => '1',
                'show_in_trader_page'             => '1',
                'show_in_main_page'             => '0',
                'price'             => '120',
                'trader_id'             => '1',
                'main_product_type_id'             => '1',
                'sub_product_type_id'             => '1',
                'main_product_service_type_id'             => '1',
                'sub_product_service_type_id'             => '1',
                'city_id'           => '1',
                'department_id'          => '1',
            ],
        ];

        \App\Models\Product::insert($products);
    }
}
