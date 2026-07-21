<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Wireless Headphones',
                'description' => 'Premium noise-cancelling wireless headphones with deep bass.',
                'price' => 4999,
                'stock' => 25,
                'image' => 'images/products/headphones.jpg',
                'category_id' => 1,
            ],
            [
                'name' => 'Smart Watch',
                'description' => 'Fitness tracking smart watch with AMOLED display.',
                'price' => 7999,
                'stock' => 15,
                'image' => 'images/products/smartwatch.webp',
                'category_id' => 1,
            ],
            [
                'name' => 'Running Shoes',
                'description' => 'Lightweight breathable running shoes for daily workouts.',
                'price' => 3499,
                'stock' => 30,
                'image' => 'images/products/shoes.webp',
                'category_id' => 2,
            ],
            [
                'name' => 'Leather Handbag',
                'description' => 'Elegant genuine leather handbag for everyday use.',
                'price' => 5999,
                'stock' => 12,
                'image' => 'images/products/handbag.webp',
                'category_id' => 2,
            ],
            [
                'name' => 'Table Lamp',
                'description' => 'Modern minimalist table lamp for home decor.',
                'price' => 2499,
                'stock' => 20,
                'image' => 'images/products/lamp.webp',
                'category_id' => 3,
            ],
            [
                'name' => 'Skincare Set',
                'description' => 'Complete skincare set with cleanser, toner, and moisturizer.',
                'price' => 3999,
                'stock' => 18,
                'image' => 'images/products/skincare.webp',
                'category_id' => 4,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}