<?php

$models = [
    'Category' => <<<EOT
    protected \$guarded = [];
    public function products() { return \$this->hasMany(Product::class); }
EOT,
    'Product' => <<<EOT
    protected \$guarded = [];
    public function category() { return \$this->belongsTo(Category::class); }
    public function images() { return \$this->hasMany(ProductImage::class); }
    public function options() { return \$this->hasMany(ProductOption::class); }
    public function addons() { return \$this->hasMany(ProductAddon::class); }
    public function reviews() { return \$this->hasMany(Review::class); }
EOT,
    'ProductImage' => <<<EOT
    protected \$guarded = [];
    public function product() { return \$this->belongsTo(Product::class); }
EOT,
    'ProductOption' => <<<EOT
    protected \$guarded = [];
    public function product() { return \$this->belongsTo(Product::class); }
EOT,
    'ProductAddon' => <<<EOT
    protected \$guarded = [];
    public function product() { return \$this->belongsTo(Product::class); }
EOT,
    'Cart' => <<<EOT
    protected \$guarded = [];
    public function user() { return \$this->belongsTo(User::class); }
    public function items() { return \$this->hasMany(CartItem::class); }
EOT,
    'CartItem' => <<<EOT
    protected \$guarded = [];
    protected \$casts = ['options' => 'array'];
    public function cart() { return \$this->belongsTo(Cart::class); }
    public function product() { return \$this->belongsTo(Product::class); }
EOT,
    'Address' => <<<EOT
    protected \$guarded = [];
    public function user() { return \$this->belongsTo(User::class); }
EOT,
    'Order' => <<<EOT
    protected \$guarded = [];
    public function user() { return \$this->belongsTo(User::class); }
    public function address() { return \$this->belongsTo(Address::class); }
    public function items() { return \$this->hasMany(OrderItem::class); }
    public function payment() { return \$this->hasOne(Payment::class); }
EOT,
    'OrderItem' => <<<EOT
    protected \$guarded = [];
    protected \$casts = ['options' => 'array'];
    public function order() { return \$this->belongsTo(Order::class); }
    public function product() { return \$this->belongsTo(Product::class); }
    public function addons() { return \$this->hasMany(OrderItemAddon::class); }
EOT,
    'OrderItemAddon' => <<<EOT
    protected \$guarded = [];
    public function orderItem() { return \$this->belongsTo(OrderItem::class); }
EOT,
    'Payment' => <<<EOT
    protected \$guarded = [];
    public function order() { return \$this->belongsTo(Order::class); }
EOT,
    'Coupon' => <<<EOT
    protected \$guarded = [];
    public function usages() { return \$this->hasMany(CouponUsage::class); }
EOT,
    'CouponUsage' => <<<EOT
    protected \$guarded = [];
    public function coupon() { return \$this->belongsTo(Coupon::class); }
    public function user() { return \$this->belongsTo(User::class); }
    public function order() { return \$this->belongsTo(Order::class); }
EOT,
    'Review' => <<<EOT
    protected \$guarded = [];
    public function user() { return \$this->belongsTo(User::class); }
    public function product() { return \$this->belongsTo(Product::class); }
EOT,
    'Favorite' => <<<EOT
    protected \$guarded = [];
    public function user() { return \$this->belongsTo(User::class); }
    public function product() { return \$this->belongsTo(Product::class); }
EOT,
    'RestaurantSetting' => <<<EOT
    protected \$guarded = [];
EOT,
    'User' => <<<EOT
    public function orders() { return \$this->hasMany(Order::class); }
    public function addresses() { return \$this->hasMany(Address::class); }
    public function reviews() { return \$this->hasMany(Review::class); }
    public function favorites() { return \$this->hasMany(Favorite::class); }
EOT
];

foreach ($models as $modelName => $contentToAdd) {
    $file = __DIR__ . "/app/Models/{$modelName}.php";
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        if ($modelName === 'User') {
            // Find end of class and inject
            $pattern = '/(class User extends Authenticatable.*?\{)(.*?)(\})/s';
            $content = preg_replace($pattern, "$1$2\n    $contentToAdd\n$3", $content);
        } else {
            $pattern = '/(class '.$modelName.' extends Model\s*\{)(\s*\/\/)/s';
            $content = preg_replace($pattern, "$1\n    $contentToAdd\n", $content);
        }
        
        file_put_contents($file, $content);
        echo "Updated $modelName\n";
    }
}
