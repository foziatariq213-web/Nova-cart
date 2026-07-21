<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->words(3, true);

        return [
            'name' => $name,
            'slug' => Str::slug($name),

            'category' => fake()->randomElement([
                'Electronics',
                'Fashion',
                'Shoes',
                'Watches',
                'Accessories',
                'Home & Living'
            ]),

            'brand' => fake()->randomElement([
                'Nike',
                'Apple',
                'Samsung',
                'Sony',
                'Adidas',
                'Zara'
            ]),

            'sku' => strtoupper(fake()->bothify('SKU-####-???')),

            'description' => fake()->paragraph(3),

            'new_price' => fake()->randomFloat(2, 50, 1500),

            'old_price' => fake()->randomFloat(2, 1500, 2500),

            'stock' => fake()->numberBetween(0, 100),

            'featured' => fake()->boolean(30),

            'status' => true,
'image' => 'products/amanda-dalbjorn-t7WrWaewbtw-unsplash (1).jpg',
        ];
    }
}