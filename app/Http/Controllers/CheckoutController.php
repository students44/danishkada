<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;

class CheckoutController extends Controller
{
    private function getCart()
    {
        return Cart::where('session_id', session()->getId())->first();
    }

    public function index()
    {
        $cart = $this->getCart();
        if (!$cart || $cart->items->count() === 0) {
            return redirect()->route('menu.index')->with('error', 'Your cart is empty');
        }
        $cart->load('items.product');
        return view('checkout.index', compact('cart'));
    }

    public function process(Request $request)
    {
        $cart = $this->getCart();
        if (!$cart || $cart->items->count() === 0) {
            return redirect()->route('menu.index');
        }

        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string',
            'payment_method' => 'required|in:cod',
        ]);

        // Create Address
        $address = Address::create([
            'user_id' => auth()->id() ?? User::first()->id, // fallback for guest
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'city' => $request->city,
            'area' => $request->area,
        ]);

        // Create Order
        $orderNumber = 'ORD-' . date('Ymd') . '-' . rand(1000, 9999);
        $order = Order::create([
            'user_id' => auth()->id() ?? User::first()->id,
            'address_id' => $address->id,
            'order_number' => $orderNumber,
            'type' => $request->type ?? 'delivery',
            'status' => 'pending',
            'subtotal' => $cart->subtotal,
            'delivery_fee' => $cart->delivery_fee,
            'tax' => $cart->tax,
            'discount' => $cart->discount,
            'total' => $cart->total,
            'payment_method' => $request->payment_method,
            'delivery_instructions' => $request->delivery_instructions,
        ]);

        // Transfer Cart Items to Order Items
        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'options' => $item->options,
                'special_instructions' => $item->special_instructions,
            ]);
        }

        // Clear Cart
        $cart->items()->delete();
        $cart->delete();

        return redirect()->route('checkout.success', $order->order_number);
    }

    public function success($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->with('items.product', 'address')->firstOrFail();
        return view('checkout.success', compact('order'));
    }
}
