<?php

use App\Models\Variant;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'id'             => 1,
                'name'           => 'category_main_test',
                'type'           => 'service',
            ],
        ];

        \App\Models\Category::insert($categories);
    }
}
