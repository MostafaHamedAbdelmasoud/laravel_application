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
                'name'           => 'رئيسية تجربة',
                'main_product_type_id'           => 1,
            ],
        ];

        \App\Models\SubProductType::insert($sub_product_types);
    }
}
