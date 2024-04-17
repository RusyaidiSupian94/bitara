<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(30)->create();

        \App\Models\Product::factory()->count(9)->sequence(
            [
                'product_name' => 'Product 1',
                'cost_price' => rand(1, 99),
                'unit_price' => rand(1, 99),
                'total_stock' => rand(1, 99),
                'category_id' => 1,
                'product_img' => 'elements/1.jpg',
                'uom_id' => 1,
            ],
            [
                'product_name' => 'Product 2',
                'cost_price' => rand(1, 99),
                'unit_price' => rand(1, 99),
                'total_stock' => rand(1, 99),
                'category_id' => 1,
                'product_img' => 'elements/2.jpg',
                'uom_id' => 1,
            ],
            [
                'product_name' => 'Product 3',
                'cost_price' => rand(1, 99),
                'unit_price' => rand(1, 99),
                'total_stock' => rand(1, 99),
                'category_id' => 1,
                'product_img' => 'elements/3.jpg',
                'uom_id' => 1,
            ],
            [
                'product_name' => 'Product 4',
                'cost_price' => rand(1, 99),
                'unit_price' => rand(1, 99),
                'total_stock' => rand(1, 99),
                'category_id' => 1,
                'product_img' => 'elements/4.jpg',
                'uom_id' => 1,
            ],
            [
                'product_name' => 'Product 5',
                'cost_price' => rand(1, 99),
                'unit_price' => rand(1, 99),
                'total_stock' => rand(1, 99),
                'category_id' => 1,
                'product_img' => 'elements/5.jpg',
                'uom_id' => 1,
            ],
            [
                'product_name' => 'Product 6',
                'cost_price' => rand(1, 99),
                'unit_price' => rand(1, 99),
                'total_stock' => rand(1, 99),
                'category_id' => 1,
                'product_img' => 'elements/6.jpg',
                'uom_id' => 1,
            ],
            [
                'product_name' => 'Product 7',
                'cost_price' => rand(1, 99),
                'unit_price' => rand(1, 99),
                'total_stock' => rand(1, 99),
                'category_id' => 1,
                'product_img' => 'elements/7.jpg',
                'uom_id' => 1,
            ],
            [
                'product_name' => 'Product 8',
                'cost_price' => rand(1, 99),
                'unit_price' => rand(1, 99),
                'total_stock' => rand(1, 99),
                'category_id' => 1,
                'product_img' => 'elements/8.jpg',
                'uom_id' => 1,
            ],
            [
                'product_name' => 'Product 9',
                'cost_price' => rand(1, 99),
                'unit_price' => rand(1, 99),
                'total_stock' => rand(1, 99),
                'category_id' => 1,
                'product_img' => 'elements/9.jpg',
                'uom_id' => 1,
            ],
        )->create();
    }
}
