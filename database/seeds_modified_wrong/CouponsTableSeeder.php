<?php

use App\Models\Variant;
use Illuminate\Database\Seeder;

class CouponsTableSeeder extends Seeder
{
    public function run()
    {
        $coupons = [
            [
                'id'             => 1,
                'code'           => 'code',
                'fixed_discount'           => 1,
                'percentage_discount'           => 1,
                'max_usage_per_user'           => 2,
            ],
        ];

        \App\Models\Coupon::insert($coupons);
    }
}
