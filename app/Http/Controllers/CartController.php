<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Str;

class CartController extends Controller
{
    private function getCart()
    {
        $sessionId = session()->getId();
        $cart = Cart::firstOrCreate(
            ['session_id' => $sessionId],
            ['user_id' => auth()->id()]
        );
        return $cart;
    }

    public function index()
    {
        $cart = $this->getCart();
        $cart->load('items.product');
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = $this->getCart();
        $product = Product::findOrFail($request->product_id);

        $price = $product->discount_price ?? $product->price;
        $options = $request->input('options', []);
        $addons = $request->input('addons', []);

        // Add options and addons price (simplified logic for prototype)
        // In a real app, we'd query ProductOption and ProductAddon to verify prices
        
        $item = CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'price' => $price,
            'options' => json_encode(['options' => $options, 'addons' => $addons]),
            'special_instructions' => $request->special_instructions
        ]);

        $this->updateCartTotals($cart);

        if ($request->has('order_now')) {
            return redirect()->route('checkout.index');
        }

        return redirect()->back()->with('success', 'Added to cart successfully!');
    }

    public function remove(Request $request)
    {
        $cart = $this->getCart();
        CartItem::where('id', $request->item_id)->where('cart_id', $cart->id)->delete();
        $this->updateCartTotals($cart);
        
        return redirect()->back()->with('success', 'Item removed');
    }
    
    public function update(Request $request)
    {
        $cart = $this->getCart();
        $item = CartItem::where('id', $request->item_id)->where('cart_id', $cart->id)->first();
        if ($item) {
            $item->quantity = $request->quantity;
            $item->save();
            $this->updateCartTotals($cart);
        }
        return redirect()->back()->with('success', 'Cart updated');
    }

    private function updateCartTotals($cart)
    {
        $subtotal = $cart->items()->sum(\DB::raw('price * quantity'));
        $cart->subtotal = $subtotal;
        $cart->tax = 0; // Configurable later
        $cart->delivery_fee = 100; // Fixed delivery fee for now
        $cart->total = $subtotal + $cart->tax + $cart->delivery_fee - $cart->discount;
        $cart->save();
    }
}
