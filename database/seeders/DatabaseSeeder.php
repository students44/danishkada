<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductAddon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User for Filament
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'), // password
        ]);

        // Customer User
        User::create([
            'name' => 'Muneeb Khan',
            'email' => 'customer@example.com',
            'password' => bcrypt('password'),
        ]);

        $categories = [
            ['name' => 'Burgers', 'slug' => 'burgers'],
            ['name' => 'Pizza', 'slug' => 'pizza'],
            ['name' => 'Drinks', 'slug' => 'drinks'],
            ['name' => 'Desserts', 'slug' => 'desserts'],
        ];

        foreach ($categories as $cat) {
            $category = Category::create($cat);

            if ($cat['name'] === 'Burgers') {
                $product = Product::create([
                    'category_id' => $category->id,
                    'name' => 'Zinger Burger',
                    'slug' => 'zinger-burger',
                    'description' => 'Crispy chicken with cheese & special sauce',
                    'price' => 599.00,
                    'is_popular' => true,
                    'is_featured' => true,
                ]);

                ProductAddon::create(['product_id' => $product->id, 'name' => 'Extra Cheese', 'price' => 100.00]);
                ProductAddon::create(['product_id' => $product->id, 'name' => 'Extra Patty', 'price' => 200.00]);
            }

            if ($cat['name'] === 'Pizza') {
                $product = Product::create([
                    'category_id' => $category->id,
                    'name' => 'Chicken Tikka Pizza',
                    'slug' => 'chicken-tikka-pizza',
                    'description' => 'Spicy chicken tikka chunks with onions and cheese',
                    'price' => 1200.00,
                    'is_popular' => true,
                ]);

                ProductOption::create(['product_id' => $product->id, 'name' => 'Size', 'value' => 'Small', 'price_adjustment' => -400.00]);
                ProductOption::create(['product_id' => $product->id, 'name' => 'Size', 'value' => 'Medium', 'price_adjustment' => 0.00]);
                ProductOption::create(['product_id' => $product->id, 'name' => 'Size', 'value' => 'Large', 'price_adjustment' => 400.00]);

                ProductOption::create(['product_id' => $product->id, 'name' => 'Crust', 'value' => 'Normal', 'price_adjustment' => 0.00]);
                ProductOption::create(['product_id' => $product->id, 'name' => 'Crust', 'value' => 'Cheese Burst', 'price_adjustment' => 250.00]);
            }
        }
    }
}
