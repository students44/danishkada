<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductAddon;
use App\Models\ProductOption;
use App\Models\RestaurantSetting;
use App\Models\Review;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DashboardDemoSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ensure Restaurant Settings
        $settings = [
            'restaurant_name' => 'DanishKada Fine Dining & Fast Food',
            'restaurant_tagline' => 'Taste That Delights Every Bite',
            'phone' => '+92 300 1234567',
            'email' => 'contact@danishkada.com',
            'address' => 'Main Boulevard, Gulberg III, Lahore, Pakistan',
            'opening_time' => '11:00 AM',
            'closing_time' => '02:00 AM',
            'currency' => 'PKR',
            'currency_symbol' => 'Rs.',
            'delivery_fee' => '150.00',
            'tax_percentage' => '5.0',
            'is_open' => '1',
            'kitchen_status' => 'active',
        ];

        foreach ($settings as $key => $val) {
            RestaurantSetting::updateOrCreate(['key' => $key], ['value' => $val]);
        }

        // 2. Ensure Categories
        $categoriesData = [
            ['name' => 'Burgers & Wraps', 'slug' => 'burgers-wraps'],
            ['name' => 'Artisan Pizzas', 'slug' => 'artisan-pizzas'],
            ['name' => 'BBQ & Platters', 'slug' => 'bbq-platters'],
            ['name' => 'Sides & Appetizers', 'slug' => 'sides-appetizers'],
            ['name' => 'Beverages & Shakes', 'slug' => 'beverages-shakes'],
            ['name' => 'Desserts', 'slug' => 'desserts'],
        ];

        $cats = [];
        foreach ($categoriesData as $c) {
            $cats[$c['slug']] = Category::firstOrCreate(['slug' => $c['slug']], ['name' => $c['name']]);
        }

        // 3. Ensure Key Products
        $productsData = [
            [
                'cat' => 'burgers-wraps',
                'name' => 'Zinger Supreme Burger',
                'slug' => 'zinger-supreme-burger',
                'price' => 650.00,
                'discount_price' => 599.00,
                'description' => 'Crispy fried chicken breast loaded with iceberg lettuce, melted cheddar, and signature garlic aioli.',
                'is_popular' => true,
                'is_featured' => true,
                'status' => true,
            ],
            [
                'cat' => 'burgers-wraps',
                'name' => 'Smoky Beef Bacon Double',
                'slug' => 'smoky-beef-bacon-double',
                'price' => 950.00,
                'discount_price' => 890.00,
                'description' => 'Two 100% prime beef smash patties, beef bacon strips, caramelized onions, and house smoky BBQ sauce.',
                'is_popular' => true,
                'is_featured' => true,
                'status' => true,
            ],
            [
                'cat' => 'artisan-pizzas',
                'name' => 'Chicken Tikka Feast Pizza',
                'slug' => 'chicken-tikka-feast-pizza',
                'price' => 1450.00,
                'discount_price' => 1350.00,
                'description' => 'Charcoal-grilled tikka chunks, capsicum, red onion, mozzarella blend on hand-tossed sourdough.',
                'is_popular' => true,
                'is_featured' => true,
                'status' => true,
            ],
            [
                'cat' => 'artisan-pizzas',
                'name' => 'Creamy Malai Boti Special',
                'slug' => 'creamy-malai-boti-special',
                'price' => 1550.00,
                'discount_price' => null,
                'description' => 'Tender malai boti cubes drizzled with rich white garlic cream sauce and herbs.',
                'is_popular' => true,
                'is_featured' => false,
                'status' => true,
            ],
            [
                'cat' => 'bbq-platters',
                'name' => 'DanishKada Royal Mix Platter',
                'slug' => 'danishkada-royal-mix-platter',
                'price' => 2800.00,
                'discount_price' => 2500.00,
                'description' => 'Skewers of mutton seekh kabab, reshmi kabab, chicken boti, fish fillet, served with parathas and dips.',
                'is_popular' => true,
                'is_featured' => true,
                'status' => true,
            ],
            [
                'cat' => 'sides-appetizers',
                'name' => 'Loaded Cheesy Dynamite Fries',
                'slug' => 'loaded-cheesy-dynamite-fries',
                'price' => 450.00,
                'discount_price' => null,
                'description' => 'Crispy golden fries drenched in hot liquid cheese, diced chicken, and spicy jalapeno sauce.',
                'is_popular' => true,
                'is_featured' => false,
                'status' => true,
            ],
            [
                'cat' => 'beverages-shakes',
                'name' => 'Belgian Dark Chocolate Shake',
                'slug' => 'belgian-dark-chocolate-shake',
                'price' => 480.00,
                'discount_price' => null,
                'description' => 'Rich Belgian cocoa churned with premium ice cream and topped with chocolate curls.',
                'is_popular' => false,
                'is_featured' => false,
                'status' => true,
            ],
            [
                'cat' => 'desserts',
                'name' => 'Molten Lava Chocolate Cake',
                'slug' => 'molten-lava-chocolate-cake',
                'price' => 520.00,
                'discount_price' => null,
                'description' => 'Freshly baked warm chocolate fondant oozing with melted ganache, served with vanilla bean ice cream.',
                'is_popular' => true,
                'is_featured' => true,
                'status' => true,
            ],
        ];

        $createdProducts = [];
        foreach ($productsData as $pd) {
            $catId = $cats[$pd['cat']]->id ?? Category::first()->id;
            $createdProducts[] = Product::firstOrCreate(
                ['slug' => $pd['slug']],
                [
                    'category_id' => $catId,
                    'name' => $pd['name'],
                    'price' => $pd['price'],
                    'discount_price' => $pd['discount_price'],
                    'description' => $pd['description'],
                    'is_popular' => $pd['is_popular'],
                    'is_featured' => $pd['is_featured'],
                    'status' => $pd['status'],
                ]
            );
        }

        // 4. Ensure Sample Customers
        $customersData = [
            ['name' => 'Ali Raza', 'email' => 'ali.raza@example.com', 'phone' => '+92 321 4455667', 'address' => 'House 42-B, Model Town', 'city' => 'Lahore'],
            ['name' => 'Zainab Fatima', 'email' => 'zainab.f@example.com', 'phone' => '+92 333 9988776', 'address' => 'Flat 301, Askari 10', 'city' => 'Lahore'],
            ['name' => 'Hamza Tariq', 'email' => 'hamza.t@example.com', 'phone' => '+92 300 5544332', 'address' => 'Plaza 14, Commercial Area, DHA Phase 5', 'city' => 'Lahore'],
            ['name' => 'Ayesha Noor', 'email' => 'ayesha.noor@example.com', 'phone' => '+92 312 8877665', 'address' => 'Villa 7, Canal View', 'city' => 'Lahore'],
            ['name' => 'Bilal Ahmed', 'email' => 'bilal.ahmed@example.com', 'phone' => '+92 345 1122334', 'address' => 'Block C, Johar Town', 'city' => 'Lahore'],
        ];

        $userAddressPairs = [];
        foreach ($customersData as $c) {
            $user = User::firstOrCreate(
                ['email' => $c['email']],
                [
                    'name' => $c['name'],
                    'password' => bcrypt('password'),
                ]
            );

            $addr = Address::firstOrCreate(
                ['user_id' => $user->id, 'address' => $c['address']],
                [
                    'full_name' => $c['name'],
                    'phone' => $c['phone'],
                    'email' => $c['email'],
                    'city' => $c['city'],
                    'is_default' => true,
                ]
            );

            $userAddressPairs[] = ['user' => $user, 'address' => $addr];
        }

        // 5. Generate Orders for the past 14 days and today if orders are less than 15
        if (Order::count() < 15) {
            $statuses = ['pending', 'confirmed', 'preparing', 'ready', 'out_for_delivery', 'delivered', 'delivered', 'delivered', 'cancelled'];
            $types = ['delivery', 'delivery', 'pickup'];
            $paymentMethods = ['Cash on Delivery', 'Credit / Debit Card', 'JazzCash', 'EasyPaisa'];

            // Generate orders spanning the past 14 days
            for ($daysAgo = 13; $daysAgo >= 0; $daysAgo--) {
                $orderCountToday = ($daysAgo === 0) ? rand(4, 7) : rand(2, 5);

                for ($i = 0; $i < $orderCountToday; $i++) {
                    $pair = $userAddressPairs[array_rand($userAddressPairs)];
                    $status = ($daysAgo === 0)
                        ? (['pending', 'confirmed', 'preparing', 'out_for_delivery', 'delivered'][array_rand(['pending', 'confirmed', 'preparing', 'out_for_delivery', 'delivered'])])
                        : (['delivered', 'delivered', 'delivered', 'cancelled'][array_rand(['delivered', 'delivered', 'delivered', 'cancelled'])]);

                    $type = $types[array_rand($types)];
                    $method = $paymentMethods[array_rand($paymentMethods)];
                    $paymentStatus = in_array($status, ['delivered', 'preparing', 'out_for_delivery']) ? 'paid' : ($status === 'cancelled' ? 'failed' : 'pending');

                    // Pick 1-3 random products
                    $itemsToOrder = [];
                    $subtotal = 0;
                    $itemPicks = (array) array_rand($createdProducts, min(rand(1, 3), count($createdProducts)));
                    foreach ($itemPicks as $pickIndex) {
                        $prod = $createdProducts[$pickIndex];
                        $qty = rand(1, 3);
                        $itemPrice = $prod->discount_price ?? $prod->price;
                        $lineTotal = $itemPrice * $qty;
                        $subtotal += $lineTotal;

                        $itemsToOrder[] = [
                            'product_id' => $prod->id,
                            'quantity' => $qty,
                            'price' => $itemPrice,
                        ];
                    }

                    $deliveryFee = ($type === 'delivery') ? 150.00 : 0.00;
                    $tax = round($subtotal * 0.05, 2);
                    $discount = ($subtotal > 2000) ? 200.00 : 0.00;
                    $total = $subtotal + $deliveryFee + $tax - $discount;

                    $createdAt = Carbon::now()->subDays($daysAgo)->setTime(rand(11, 23), rand(0, 59), rand(0, 59));

                    $order = Order::create([
                        'user_id' => $pair['user']->id,
                        'address_id' => $pair['address']->id,
                        'order_number' => 'DK-' . strtoupper(Str::random(6)) . '-' . rand(100, 999),
                        'type' => $type,
                        'status' => $status,
                        'subtotal' => $subtotal,
                        'delivery_fee' => $deliveryFee,
                        'discount' => $discount,
                        'tax' => $tax,
                        'total' => $total,
                        'payment_method' => $method,
                        'payment_status' => $paymentStatus,
                        'delivery_instructions' => 'Please ring the bell and leave at door if busy.',
                        'created_at' => $createdAt,
                        'updated_at' => $createdAt,
                    ]);

                    foreach ($itemsToOrder as $item) {
                        OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $item['product_id'],
                            'quantity' => $item['quantity'],
                            'price' => $item['price'],
                            'created_at' => $createdAt,
                            'updated_at' => $createdAt,
                        ]);
                    }
                }
            }
        }

        // 6. Seed Sample Reviews
        if (Review::count() < 6 && count($createdProducts) > 0) {
            $sampleReviews = [
                ['rating' => 5, 'comment' => 'The Zinger Supreme was insanely juicy and crispy! Best burger in Lahore by far.', 'status' => 'approved'],
                ['rating' => 5, 'comment' => 'Pizza crust was soft, toppings were generous. Loved the melted cheese blend!', 'status' => 'approved'],
                ['rating' => 4, 'comment' => 'Royal mix platter was fabulous! Loved the tender reshmi kababs.', 'status' => 'approved'],
                ['rating' => 5, 'comment' => 'Molten lava cake was warm and chocolatey heaven! Highly recommended dessert.', 'status' => 'approved'],
                ['rating' => 4, 'comment' => 'Dynamite fries had the perfect kick of spice. Fast delivery as well.', 'status' => 'approved'],
            ];

            foreach ($sampleReviews as $idx => $rev) {
                $p = $createdProducts[$idx % count($createdProducts)];
                $u = $userAddressPairs[$idx % count($userAddressPairs)]['user'];
                Review::firstOrCreate(
                    ['user_id' => $u->id, 'product_id' => $p->id],
                    [
                        'rating' => $rev['rating'],
                        'comment' => $rev['comment'],
                        'status' => $rev['status'],
                    ]
                );
            }
        }
    }
}
