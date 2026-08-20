@extends('layouts.app')

@section('content')
<div class="bg-gray-50 py-12 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Checkout</h1>

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Delivery Info -->
                <div class="w-full lg:w-2/3 space-y-6">
                    <!-- Personal Info -->
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                        <h2 class="text-xl font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">Contact Information</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                <input type="text" name="full_name" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary" placeholder="John Doe">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                <input type="tel" name="phone" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary" placeholder="0300 1234567">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email Address (Optional)</label>
                                <input type="email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary" placeholder="john@example.com">
                            </div>
                        </div>
                    </div>

                    <!-- Address Info -->
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                        <h2 class="text-xl font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">Delivery Address</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Street Address</label>
                                <input type="text" name="address" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary" placeholder="House #, Street name">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">City</label>
                                <input type="text" name="city" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary" placeholder="Karachi">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Area / Block</label>
                                <input type="text" name="area" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary" placeholder="Gulshan-e-Iqbal">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Delivery Instructions (Optional)</label>
                                <textarea name="delivery_instructions" rows="2" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary" placeholder="Leave at the door..."></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment Method -->
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                        <h2 class="text-xl font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">Payment Method</h2>
                        
                        <div class="space-y-4">
                            <label class="flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition-colors border-primary bg-primary/5">
                                <input type="radio" name="payment_method" value="cod" checked class="w-5 h-5 text-primary border-gray-300 focus:ring-primary">
                                <div class="ml-4">
                                    <span class="block text-gray-900 font-bold">Cash on Delivery</span>
                                    <span class="block text-sm text-gray-500">Pay when you receive your order</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="w-full lg:w-1/3">
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 sticky top-24">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Order Summary</h3>
                        
                        <ul class="divide-y divide-gray-200 mb-6 border-b border-gray-200 pb-6">
                            @foreach($cart->items as $item)
                                <li class="py-4 flex">
                                    <div class="ml-3 flex-1 flex flex-col">
                                        <div class="flex justify-between text-sm font-bold text-gray-900">
                                            <h3>{{ $item->product->name }} x {{ $item->quantity }}</h3>
                                            <p class="ml-4">Rs. {{ number_format($item->price * $item->quantity) }}</p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                        <div class="flow-root">
                            <dl class="text-sm text-gray-600 space-y-4">
                                <div class="flex items-center justify-between">
                                    <dt>Subtotal</dt>
                                    <dd class="font-medium text-gray-900">Rs. {{ number_format($cart->subtotal) }}</dd>
                                </div>
                                <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                                    <dt>Delivery Fee</dt>
                                    <dd class="font-medium text-gray-900">Rs. {{ number_format($cart->delivery_fee) }}</dd>
                                </div>
                                <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                                    <dt class="text-base font-bold text-gray-900">Total</dt>
                                    <dd class="text-xl font-bold text-primary">Rs. {{ number_format($cart->total) }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div class="mt-8">
                            <button type="submit" class="w-full flex justify-center items-center px-6 py-4 border border-transparent rounded-xl shadow-sm text-base font-bold text-white bg-primary hover:bg-red-600 transition-colors">
                                Place Order
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
