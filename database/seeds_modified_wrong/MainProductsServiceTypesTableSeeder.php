<?php

use App\Models\Variant;
use Illuminate\Database\Seeder;

class MainProductsServiceTypesTableSeeder extends Seeder
{
    public function run()
    {
        $main_product_service_types = [
            [
                'id'             => 1,
                'name'           => 'main_product_service_type',
            ],
        ];

        \App\Models\MainProductServiceType::insert($main_product_service_types);
    }
}
