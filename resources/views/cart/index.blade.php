@extends('layouts.app')

@section('content')
<div class="bg-gray-50 py-12 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Your Cart</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(!$cart || $cart->items->count() == 0)
            <div class="bg-white p-12 text-center rounded-3xl shadow-sm border border-gray-100">
                <svg class="w-20 h-20 text-gray-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Your cart is empty</h2>
                <p class="text-gray-500 mb-8">Looks like you haven't added anything to your cart yet.</p>
                <a href="{{ route('menu.index') }}" class="inline-flex items-center px-8 py-3 border border-transparent text-base font-medium rounded-full shadow-sm text-white bg-primary hover:bg-red-600">
                    Browse Menu
                </a>
            </div>
        @else
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Cart Items -->
                <div class="w-full lg:w-2/3">
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                        <ul class="divide-y divide-gray-200">
                            @foreach($cart->items as $item)
                                <li class="p-6 flex flex-col sm:flex-row">
                                    <div class="flex-shrink-0 w-24 h-24 bg-gray-100 rounded-xl overflow-hidden mb-4 sm:mb-0">
                                        @if($item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover">
                                        @else
                                            <img src="https://images.unsplash.com/photo-1568901346375-23c9450c58cd?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                    <div class="sm:ml-6 flex-1 flex flex-col justify-between">
                                        <div class="flex justify-between">
                                            <div>
                                                <h3 class="text-lg font-bold text-gray-900"><a href="{{ route('menu.show', $item->product->slug) }}">{{ $item->product->name }}</a></h3>
                                                @php $opts = json_decode($item->options, true) ?? []; @endphp
                                                @if(!empty($opts['options']))
                                                    <p class="mt-1 text-sm text-gray-500">
                                                        Options: {{ collect($opts['options'])->values()->implode(', ') }}
                                                    </p>
                                                @endif
                                            </div>
                                            <p class="text-lg font-bold text-gray-900">Rs. {{ number_format($item->price * $item->quantity) }}</p>
                                        </div>
                                        <div class="mt-4 flex items-center justify-between">
                                            <form action="{{ route('cart.update') }}" method="POST" class="flex items-center border border-gray-300 rounded-lg">
                                                @csrf
                                                <input type="hidden" name="item_id" value="{{ $item->id }}">
                                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="w-16 h-10 text-center font-semibold focus:outline-none" onchange="this.form.submit()">
                                            </form>
                                            
                                            <form action="{{ route('cart.remove') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="item_id" value="{{ $item->id }}">
                                                <button type="submit" class="text-sm font-medium text-red-500 hover:text-red-700 flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    Remove
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="w-full lg:w-1/3">
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 sticky top-24">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Order Summary</h3>
                        
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
                                @if($cart->tax > 0)
                                <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                                    <dt>Tax</dt>
                                    <dd class="font-medium text-gray-900">Rs. {{ number_format($cart->tax) }}</dd>
                                </div>
                                @endif
                                <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                                    <dt class="text-base font-bold text-gray-900">Total</dt>
                                    <dd class="text-xl font-bold text-primary">Rs. {{ number_format($cart->total) }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div class="mt-8">
                            <a href="{{ route('checkout.index') }}" class="w-full flex justify-center items-center px-6 py-4 border border-transparent rounded-xl shadow-sm text-base font-bold text-white bg-primary hover:bg-red-600 transition-colors">
                                Proceed to Checkout
                            </a>
                        </div>
                        <div class="mt-4 text-center">
                            <a href="{{ route('menu.index') }}" class="text-sm font-medium text-primary hover:text-red-600">
                                or Continue Shopping <span aria-hidden="true"> &rarr;</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
