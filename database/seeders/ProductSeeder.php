<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductUnit;
use App\Models\Unit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        $units = Unit::all();

        if ($categories->isEmpty() || $units->isEmpty()) {
            $this->command->warn('Please seed categories and units first.');
            return;
        }

        $productNames = [
            'فلفل أسود حب',
            'فلفل أسود مطحون',
            'كمون حب',
            'كمون مطحون',
            'كزبرة حب',
            'كزبرة مطحونة',
            'كركم أصابع',
            'كركم مطحون',
            'قرفة عيدان',
            'قرفة مطحونة',
            'هيل حب أمريكي',
            'هيل حب هندي',
            'زنجبيل مطحون',
            'زنجبيل مجفف',
            'زعفران فاخر',
            'زعفران سوبر',
            'بابريكا حلوة',
            'بابريكا مدخنة',
            'شطة مجروشة حارة',
            'شطة بودرة',
            'قرنفل مسمار',
            'قرنفل مطحون',
            'جوزة الطيب حب',
            'جوزة الطيب مطحونة',
            'يانسون حب',
            'يانسون نجمي',
            'شمر حب',
            'حبة البركة (الحبة السوداء)',
            'سمسم أبيض',
            'سمسم محمص',
            'زعتر بري',
            'زعتر فلسطيني',
            'ريحان مجفف',
            'نعناع مجفف فاخر',
            'ورق غار تركي',
            'لومي أسود كامل',
            'لومي أسود مطحون',
            'كاري مدراس',
            'بهارات مشكلة (سبع بهارات)',
            'بهارات دجاج خاصة',
            'بهارات لحم كبسة',
            'بهارات سمك مقلي',
            'بهارات برياني حار',
            'بهارات كبسة سعودية',
            'ملح الهيمالايا الوردي',
            'ملح بحري خشن',
            'ملح طعام ناعم',
            'سماق بلدي',
            'ثوم بودرة',
            'بصل بودرة'
        ];

        foreach ($productNames as $index => $name) {
            $category = $categories->random();

            // Create Product
            $product = Product::create([
                'name' => $name,
                'slug' => Str::slug($name) . '-' . ($index + 1),
                'category_id' => $category->id,
                'status' => 'active',
                'is_featured' => rand(0, 1) == 1,
                'short_description' => 'بهارات عالية الجودة - ' . $name,
                'description' => 'تم اختيار هذا المنتج بعناية فائقة لضمان أفضل نكهة وجودة. ' . $name . ' من أفضل المزارع.',
            ]);

            // Assign Units (1 to 3 units per product)
            $numberOfUnits = rand(1, 3);
            $randomUnits = $units->random($numberOfUnits);

            foreach ($randomUnits as $key => $unit) {
                $isDefault = ($key === 0); // First unit is default
                $costPrice = rand(5, 50);
                $sellingPrice = $costPrice * 1.5; // 50% margin
                $packageSize = 1;

                // Adjust logic based on unit name if possible, otherwise random
                if (Str::contains($unit->name, 'كرتون')) {
                    $packageSize = 12;
                    $costPrice *= 10; // Bulk discount logic roughly
                    $sellingPrice = $costPrice * 1.3;
                } elseif (Str::contains($unit->name, 'كيلو')) {
                    $packageSize = 1000; // Assuming base is gram, or just 1 if base is KG. Let's assume 1 for simplicity of "1 Unit"
                }

                ProductUnit::create([
                    'product_id' => $product->id,
                    'unit_id' => $unit->id,
                    'package_size' => $packageSize,
                    'cost_price' => $costPrice,
                    'selling_price' => $sellingPrice,
                    'stock' => rand(100, 1000),
                    'moq' => 1,
                    'is_default' => $isDefault,
                    'status' => 'active',
                    'sort_order' => $key + 1,
                ]);
            }
        }
    }
}
