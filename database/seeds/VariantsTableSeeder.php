<?php

use App\Models\Variant;
use Illuminate\Database\Seeder;

class VariantsTableSeeder extends Seeder
{
    public function run()
    {
        $variants = [
            [
                'id'             => 1,
                'color'           => 'أحمر',
                'size'          => 'X Large',
                'price'          => '5.55',
                'count'       => 6,
            ],
        ];

        Variant::insert($variants);
    }
}
