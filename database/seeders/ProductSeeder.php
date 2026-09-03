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
                'new_price' => 4999,
                'stock' => 25,
                'image' => 'uploads/products/1783704020_6a5129d4e93c1.jpg',
                'category_id' => 1,
            ],
            [
                'name' => 'Smart Watch',
                'description' => 'Fitness tracking smart watch with AMOLED display.',
                'new_price' => 7999,
                'stock' => 15,
                'image' => 'images/products/smartwatch.webp',
                'category_id' => 1,
            ],
            [
                'name' => 'Running Shoes',
                'description' => 'Lightweight breathable running shoes for daily workouts.',
                'new_price' => 3499,
                'stock' => 30,
                'image' => 'images/products/shoes.webp',
                'category_id' => 2,
            ],
            [
                'name' => 'Leather Handbag',
                'description' => 'Elegant genuine leather handbag for everyday use.',
                'new_price' => 5999,
                'stock' => 12,
                'image' => 'images/products/handbag.webp',
                'category_id' => 2,
            ],
            [
                'name' => 'Table Lamp',
                'description' => 'Modern minimalist table lamp for home decor.',
                'new_price' => 2499,
                'stock' => 20,
                'image' => 'images/products/lamp.webp',
                'category_id' => 3,
            ],
            [
                'name' => 'Skincare Set',
                'description' => 'Complete skincare set with cleanser, toner, and moisturizer.',
                'new_price' => 3999,
                'stock' => 18,
                'image' => 'images/products/skincare.webp',
                'category_id' => 4,
            ],

            // ===== 5 new products, using your original uploaded images =====
            [
                'name' => 'Bluetooth Party Speaker',
                'description' => 'Portable Bluetooth speaker with vibrant LED light show and deep bass.',
                'new_price' => 6499,
                'stock' => 20,
                'image' => 'uploads/products/1783704294_6a512ae6e0a75.jpg',
                'category_id' => 1,
            ],
            [
                'name' => 'Slim Laptop',
                'description' => 'Lightweight, powerful laptop for work, study, and everyday computing.',
                'new_price' => 124999,
                'stock' => 8,
                'image' => 'uploads/products/1783704723_6a512c9328849.jpg',
                'category_id' => 1,
            ],
            [
                'name' => 'Faux Leather Biker Jacket',
                'description' => 'Stylish oversized faux leather jacket with zip detailing.',
                'new_price' => 8999,
                'stock' => 14,
                'image' => 'uploads/products/1783705042_6a512dd2bd5ab.jpg',
                'category_id' => 2,
            ],
            [
                'name' => 'Round Metal Sunglasses',
                'description' => 'Classic round-frame sunglasses with polarized lenses.',
                'new_price' => 2999,
                'stock' => 22,
                'image' => 'uploads/products/1783705220_6a512e84f3732.jpg',
                'category_id' => 2,
            ],
            [
                'name' => 'Premium Leather Belt',
                'description' => 'Genuine leather formal belt with a sleek auto-lock buckle.',
                'new_price' => 3499,
                'stock' => 25,
                'image' => 'uploads/products/1783705589_6a512ff50fddc.jpg',
                'category_id' => 2,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}