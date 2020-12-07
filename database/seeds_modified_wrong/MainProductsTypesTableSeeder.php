<?php

use App\Models\Variant;
use Illuminate\Database\Seeder;

class MainProductsTypesTableSeeder extends Seeder
{
    public function run()
    {
        $main_product_types = [
            [
                'id'             => 1,
                'name'           => 'main_product_type_test',
            ],
        ];

        \App\Models\MainProductType::insert($main_product_types);
    }
}
