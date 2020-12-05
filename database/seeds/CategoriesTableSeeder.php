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
                'name'           => 'رئيسية تجربة',
                'type'           => 'service',
            ],
        ];

        \App\Models\Category::insert($categories);
    }
}
