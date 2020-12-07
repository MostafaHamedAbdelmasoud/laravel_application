<?php

use App\Models\Variant;
use Illuminate\Database\Seeder;

class SubProductsServiceTypesTableSeeder extends Seeder
{
    public function run()
    {
        $sub_product_service_types = [
            [
                'id'             => 1,
                'name'           => 'sub_product_service_type_test',
                'main_product_service_type_id'           => 1,
            ],
        ];

        \App\Models\SubProductServiceType::insert($sub_product_service_types);
    }
}
