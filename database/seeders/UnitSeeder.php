<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            'كيلو',
            'جرام',
            'كرتون',
            'حبة',
            'درزن',
            'ربطة',
            'كيس',
            'علبة',
            'طن',
            'لتر'
        ];

        foreach ($units as $index => $unit) {
            Unit::create([
                'name' => $unit,
                'active' => true,
                'sort_order' => $index + 1,
            ]);
        }
    }
}
