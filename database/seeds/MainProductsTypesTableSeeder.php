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
                'name'           => 'رئيسية تجربة',
            ],
        ];

        \App\Models\MainProductType::insert($main_product_types);
    }
}
