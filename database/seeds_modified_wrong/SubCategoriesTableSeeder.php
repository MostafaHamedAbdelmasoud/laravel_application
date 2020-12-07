<?php

use App\Models\Variant;
use Illuminate\Database\Seeder;

class SubCategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $sub_categories = [
            [
                'id'             => 1,
                'name'           => 'sub_category_main_test',
                'category_id'           =>1,
            ],
        ];

        \App\Models\SubCategory::insert($sub_categories);
    }
}
