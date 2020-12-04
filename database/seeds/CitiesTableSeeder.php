<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    public function run()
    {
        $cities = [
            [
                'id'    => 1,
                'name' => 'القاهرة',
            ],
            [
                'id'    => 2,
                'name' => 'الأقصر',
            ],
        ];

        \App\Models\City::insert($cities);
    }
}
