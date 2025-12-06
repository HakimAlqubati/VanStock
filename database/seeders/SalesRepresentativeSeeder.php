<?php

namespace Database\Seeders;

use App\Models\SalesRepresentative;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SalesRepresentativeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arabicNames = [
            'أحمد محمد',
            'خالد علي',
            'عمر حسن',
            'يوسف إبراهيم',
            'محمد عبدالله',
            'سعيد صالح',
            'عبدالرحمن ناصر',
            'فهد سالم',
            'سلطان حمد',
            'فيصل عبدالعزيز',
            'ماجد سعود',
            'تركي بندر',
            'نايف مشعل',
            'وليد خالد',
            'ياسر فهد',
            'طارق زياد',
            'بسام سامي',
            'عمار جمال',
            'هشام رائد',
            'زياد طلال'
        ];

        foreach ($arabicNames as $index => $name) {
            $email = 'rep' . ($index + 1) . '@example.com';

            // Create User
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make('password'), // Default password
            ]);

            // Create Sales Representative
            SalesRepresentative::create([
                'user_id' => $user->id,
                'name' => $name,
                'email' => $email,
                'phone' => '9677' . str_pad((string)rand(0, 99999999), 8, '0', STR_PAD_LEFT),
                'rep_code' => 'REP-' . str_pad((string)($index + 1), 3, '0', STR_PAD_LEFT),
                'cash_wallet' => 0,
                'credit_limit_allowance' => 1000,
                'commission_rate' => 5,
                'is_active' => true,
            ]);
        }
    }
}
