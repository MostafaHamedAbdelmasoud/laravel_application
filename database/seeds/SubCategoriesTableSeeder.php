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
                'name'           => 'فرعية تجربة',
                'category_id'           =>1,
            ],
        ];

        \App\Models\SubCategory::insert($sub_categories);
    }
}
