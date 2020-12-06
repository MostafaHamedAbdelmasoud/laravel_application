<?php

use App\Models\Variant;
use Illuminate\Database\Seeder;

class TraderTableSeeder extends Seeder
{
    public function run()
    {
        $traders = [
            [
                'name'             => 'trader_name',
            ],
        ];

        \App\Models\Trader::insert($traders);
    }
}
