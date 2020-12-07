<?php

use App\Models\Variant;
use Illuminate\Database\Seeder;

class SubProductsTypesTableSeeder extends Seeder
{
    public function run()
    {
        $sub_product_types = [
            [
                'id'             => 1,
                'name'           => 'sub_product_type_test_',
                'main_product_type_id'           => 1,
            ],
        ];

        \App\Models\SubProductType::insert($sub_product_types);
    }
}
