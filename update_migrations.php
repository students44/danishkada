<?php

$migrations = [
    'categories' => <<<EOT
            \$table->id();
            \$table->string('name');
            \$table->string('slug')->unique();
            \$table->string('image')->nullable();
            \$table->boolean('status')->default(true);
            \$table->timestamps();
EOT,
    'products' => <<<EOT
            \$table->id();
            \$table->foreignId('category_id')->constrained()->cascadeOnDelete();
            \$table->string('name');
            \$table->string('slug')->unique();
            \$table->text('description')->nullable();
            \$table->decimal('price', 10, 2);
            \$table->decimal('discount_price', 10, 2)->nullable();
            \$table->string('image')->nullable();
            \$table->string('sku')->nullable();
            \$table->boolean('status')->default(true);
            \$table->boolean('is_featured')->default(false);
            \$table->boolean('is_popular')->default(false);
            \$table->text('ingredients')->nullable();
            \$table->timestamps();
EOT,
    'product_images' => <<<EOT
            \$table->id();
            \$table->foreignId('product_id')->constrained()->cascadeOnDelete();
            \$table->string('image');
            \$table->timestamps();
EOT,
    'product_options' => <<<EOT
            \$table->id();
            \$table->foreignId('product_id')->constrained()->cascadeOnDelete();
            \$table->string('name'); // e.g., Size, Crust
            \$table->string('value'); // e.g., Small, Cheese Burst
            \$table->decimal('price_adjustment', 10, 2)->default(0);
            \$table->timestamps();
EOT,
    'product_addons' => <<<EOT
            \$table->id();
            \$table->foreignId('product_id')->constrained()->cascadeOnDelete();
            \$table->string('name');
            \$table->decimal('price', 10, 2);
            \$table->timestamps();
EOT,
    'carts' => <<<EOT
            \$table->id();
            \$table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            \$table->string('session_id')->nullable();
            \$table->decimal('subtotal', 10, 2)->default(0);
            \$table->decimal('tax', 10, 2)->default(0);
            \$table->decimal('delivery_fee', 10, 2)->default(0);
            \$table->decimal('discount', 10, 2)->default(0);
            \$table->decimal('total', 10, 2)->default(0);
            \$table->timestamps();
EOT,
    'cart_items' => <<<EOT
            \$table->id();
            \$table->foreignId('cart_id')->constrained()->cascadeOnDelete();
            \$table->foreignId('product_id')->constrained()->cascadeOnDelete();
            \$table->integer('quantity')->default(1);
            \$table->decimal('price', 10, 2);
            \$table->json('options')->nullable(); // stored selected addons/options
            \$table->text('special_instructions')->nullable();
            \$table->timestamps();
EOT,
    'addresses' => <<<EOT
            \$table->id();
            \$table->foreignId('user_id')->constrained()->cascadeOnDelete();
            \$table->string('full_name');
            \$table->string('phone');
            \$table->string('email')->nullable();
            \$table->string('address');
            \$table->string('city');
            \$table->string('area')->nullable();
            \$table->string('postal_code')->nullable();
            \$table->boolean('is_default')->default(false);
            \$table->timestamps();
EOT,
    'orders' => <<<EOT
            \$table->id();
            \$table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            \$table->foreignId('address_id')->nullable()->constrained()->nullOnDelete();
            \$table->string('order_number')->unique();
            \$table->enum('type', ['delivery', 'pickup'])->default('delivery');
            \$table->enum('status', ['pending', 'confirmed', 'preparing', 'ready', 'out_for_delivery', 'delivered', 'cancelled'])->default('pending');
            \$table->decimal('subtotal', 10, 2);
            \$table->decimal('delivery_fee', 10, 2)->default(0);
            \$table->decimal('discount', 10, 2)->default(0);
            \$table->decimal('tax', 10, 2)->default(0);
            \$table->decimal('total', 10, 2);
            \$table->string('payment_method')->default('cod');
            \$table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            \$table->text('delivery_instructions')->nullable();
            \$table->timestamps();
EOT,
    'order_items' => <<<EOT
            \$table->id();
            \$table->foreignId('order_id')->constrained()->cascadeOnDelete();
            \$table->foreignId('product_id')->constrained()->cascadeOnDelete();
            \$table->integer('quantity');
            \$table->decimal('price', 10, 2);
            \$table->json('options')->nullable();
            \$table->text('special_instructions')->nullable();
            \$table->timestamps();
EOT,
    'order_item_addons' => <<<EOT
            \$table->id();
            \$table->foreignId('order_item_id')->constrained()->cascadeOnDelete();
            \$table->string('name');
            \$table->decimal('price', 10, 2);
            \$table->timestamps();
EOT,
    'payments' => <<<EOT
            \$table->id();
            \$table->foreignId('order_id')->constrained()->cascadeOnDelete();
            \$table->string('transaction_id')->nullable();
            \$table->string('payment_method');
            \$table->decimal('amount', 10, 2);
            \$table->enum('status', ['pending', 'success', 'failed'])->default('pending');
            \$table->timestamps();
EOT,
    'coupons' => <<<EOT
            \$table->id();
            \$table->string('code')->unique();
            \$table->enum('type', ['percentage', 'fixed']);
            \$table->decimal('value', 10, 2);
            \$table->decimal('min_order_amount', 10, 2)->default(0);
            \$table->date('expiry_date')->nullable();
            \$table->integer('usage_limit')->nullable();
            \$table->integer('used_count')->default(0);
            \$table->timestamps();
EOT,
    'coupon_usages' => <<<EOT
            \$table->id();
            \$table->foreignId('coupon_id')->constrained()->cascadeOnDelete();
            \$table->foreignId('user_id')->constrained()->cascadeOnDelete();
            \$table->foreignId('order_id')->constrained()->cascadeOnDelete();
            \$table->timestamps();
EOT,
    'reviews' => <<<EOT
            \$table->id();
            \$table->foreignId('user_id')->constrained()->cascadeOnDelete();
            \$table->foreignId('product_id')->constrained()->cascadeOnDelete();
            \$table->integer('rating')->default(5); // 1-5
            \$table->text('comment')->nullable();
            \$table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            \$table->timestamps();
EOT,
    'favorites' => <<<EOT
            \$table->id();
            \$table->foreignId('user_id')->constrained()->cascadeOnDelete();
            \$table->foreignId('product_id')->constrained()->cascadeOnDelete();
            \$table->timestamps();
EOT,
    'restaurant_settings' => <<<EOT
            \$table->id();
            \$table->string('key')->unique();
            \$table->text('value')->nullable();
            \$table->timestamps();
EOT
];

$files = glob(__DIR__ . '/database/migrations/*_create_*_table.php');

foreach ($files as $file) {
    preg_match('/create_(.*)_table/', $file, $matches);
    if (!empty($matches) && isset($migrations[$matches[1]])) {
        $tableName = $matches[1];
        $schema = $migrations[$tableName];
        
        $content = file_get_contents($file);
        
        $pattern = '/(Schema::create\(\''.$tableName.'\', function \(Blueprint \$table\) \{)(.*?)(\}\);)/s';
        
        $newContent = preg_replace($pattern, "$1\n$schema\n        $3", $content);
        file_put_contents($file, $newContent);
        echo "Updated \$tableName migration\n";
    }
}
