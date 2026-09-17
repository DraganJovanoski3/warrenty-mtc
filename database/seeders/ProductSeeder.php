<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['part_number' => 'MTC-1001', 'description' => 'Brake Pad Set – Front'],
            ['part_number' => 'MTC-1002', 'description' => 'Brake Pad Set – Rear'],
            ['part_number' => 'MTC-2001', 'description' => 'Air Filter Element'],
            ['part_number' => 'MTC-3001', 'description' => 'Oil Filter'],
            ['part_number' => 'MTC-4001', 'description' => 'Clutch Kit'],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['part_number' => $product['part_number']],
                [
                    'description' => $product['description'],
                    'is_active' => true,
                ]
            );
        }
    }
}
