<?php

use App\Models\Variant;
use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{
    public function run()
    {
        $departments = [
            [
                'id'             => 1,
                'name'             => 'ali baba!',
                'about'             => 'hello every one lorem!',
                'phone_number'             => '12445',
                'trader_id'             => '1',
                'category_id'             => '1',
                'sub_category_id'             => '1',
                'city_id'           => '1',
            ],
        ];

        \App\Models\Department::insert($departments);
    }
}
