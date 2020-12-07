<?php

use App\Models\Variant;
use Illuminate\Database\Seeder;

class SpecializationTableSeeder extends Seeder
{
    public function run()
    {
        $specializations = [
            [
                'id'             => 1,
                'name'           => 'مهندس',
            ],
        ];

        \App\Models\Specialization::insert($specializations);
    }
}
