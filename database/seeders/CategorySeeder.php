<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $spices = [
            'فلفل أسود',
            'كمون',
            'كزبرة',
            'كركم',
            'قرفة',
            'هيل',
            'زنجبيل',
            'زعفران',
            'بابريكا',
            'شطة مجروشة',
            'قرنفل',
            'جوزة الطيب',
            'يانسون',
            'شمر',
            'حبة البركة',
            'سمسم',
            'زعتر',
            'ريحان',
            'نعناع مجفف',
            'ورق غار',
            'لومي (ليمون أسود)',
            'كاري',
            'بهارات مشكلة',
            'بهارات دجاج',
            'بهارات لحم',
            'بهارات سمك',
            'بهارات برياني',
            'بهارات كبسة',
            'ملح الهيمالايا',
            'ملح بحري'
        ];

        foreach ($spices as $index => $spice) {
            Category::create([
                'name' => $spice,
                'active' => true,
                'sort_order' => $index + 1,
            ]);
        }
    }
}
