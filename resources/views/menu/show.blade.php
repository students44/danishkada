@extends('layouts.app')

@section('content')
<div class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3 text-sm text-gray-500">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Home</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-gray-400 mx-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        <a href="{{ route('menu.index') }}" class="hover:text-primary transition-colors">Menu</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-gray-400 mx-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        <a href="{{ route('menu.index', ['category' => $product->category->slug]) }}" class="hover:text-primary transition-colors">{{ $product->category->name }}</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-gray-400 mx-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        <span class="text-gray-900 font-medium">{{ $product->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="bg-white rounded-3xl shadow-sm overflow-hidden mb-12">
            <div class="flex flex-col lg:flex-row">
                <!-- Product Image -->
                <div class="w-full lg:w-1/2 bg-gray-100 relative">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover min-h-[400px]" alt="{{ $product->name }}">
                    @else
                        <img src="https://images.unsplash.com/photo-1568901346375-23c9450c58cd?q=80&w=1000&auto=format&fit=crop" class="w-full h-full object-cover min-h-[400px]" alt="{{ $product->name }}">
                    @endif
                    
                    @if($product->discount_price)
                        <div class="absolute top-6 left-6 bg-primary text-white text-sm font-bold px-3 py-1 rounded-md shadow-lg">
                            Sale
                        </div>
                    @endif
                </div>

                <!-- Product Details -->
                <div class="w-full lg:w-1/2 p-8 lg:p-12 flex flex-col">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <span class="text-sm font-bold text-primary tracking-wider uppercase mb-2 block">{{ $product->category->name }}</span>
                            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>
                        </div>
                        <div class="flex items-center bg-gray-50 px-3 py-1 rounded-full">
                            <span class="text-yellow-400 mr-1">★</span>
                            <span class="font-bold text-gray-900">{{ number_format($averageRating, 1) }}</span>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        @if($product->discount_price)
                            <div class="flex items-center space-x-3">
                                <span class="text-3xl font-bold text-gray-900">Rs. {{ number_format($product->discount_price) }}</span>
                                <span class="text-lg text-gray-400 line-through">Rs. {{ number_format($product->price) }}</span>
                            </div>
                        @else
                            <span class="text-3xl font-bold text-gray-900">Rs. {{ number_format($product->price) }}</span>
                        @endif
                    </div>
                    
                    <p class="text-gray-600 text-lg mb-8 leading-relaxed">
                        {{ $product->description }}
                    </p>

                    <form action="{{ route('cart.add') }}" method="POST" class="mt-auto flex flex-col gap-6">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        <!-- Options (e.g., Size, Crust) -->
                        @if($product->options->count() > 0)
                            @php
                                $groupedOptions = $product->options->groupBy('name');
                            @endphp
                            
                            @foreach($groupedOptions as $optionName => $options)
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-3">{{ $optionName }}</h4>
                                    <div class="flex flex-wrap gap-3">
                                        @foreach($options as $index => $option)
                                            <label class="cursor-pointer">
                                                <input type="radio" name="options[{{ $optionName }}]" value="{{ $option->value }}" class="peer sr-only" {{ $index === 0 ? 'checked' : '' }}>
                                                <div class="px-4 py-2 rounded-lg border-2 border-gray-200 peer-checked:border-primary peer-checked:bg-primary/5 hover:border-primary/50 transition-all">
                                                    <span class="block font-medium text-gray-900">{{ $option->value }}</span>
                                                    @if($option->price_adjustment > 0)
                                                        <span class="block text-xs text-gray-500">+ Rs. {{ number_format($option->price_adjustment) }}</span>
                                                    @elseif($option->price_adjustment < 0)
                                                        <span class="block text-xs text-gray-500">- Rs. {{ number_format(abs($option->price_adjustment)) }}</span>
                                                    @endif
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        <!-- Addons -->
                        @if($product->addons->count() > 0)
                            <div>
                                <h4 class="font-bold text-gray-900 mb-3">Add-ons</h4>
                                <div class="space-y-2">
                                    @foreach($product->addons as $addon)
                                        <label class="flex items-center justify-between p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                                            <div class="flex items-center space-x-3">
                                                <input type="checkbox" name="addons[]" value="{{ $addon->id }}" class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary">
                                                <span class="font-medium text-gray-900">{{ $addon->name }}</span>
                                            </div>
                                            <span class="text-gray-600">+ Rs. {{ number_format($addon->price) }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        
                        <!-- Special Instructions -->
                        <div>
                            <h4 class="font-bold text-gray-900 mb-3">Special Instructions (Optional)</h4>
                            <textarea name="special_instructions" rows="2" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary" placeholder="E.g., No mayo, extra spicy..."></textarea>
                        </div>

                        <!-- Quantity & Buttons -->
                        <div class="flex flex-col sm:flex-row items-end gap-4 mt-4 pt-6 border-t border-gray-100">
                            <div class="w-full sm:w-1/3">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Quantity</label>
                                <div class="flex items-center border border-gray-300 rounded-lg bg-white h-12">
                                    <button type="button" class="w-10 h-full text-gray-600 hover:text-primary flex items-center justify-center border-r border-gray-300 transition-colors">-</button>
                                    <input type="number" name="quantity" value="1" min="1" class="w-full h-full text-center font-bold focus:outline-none bg-transparent">
                                    <button type="button" class="w-10 h-full text-gray-600 hover:text-primary flex items-center justify-center border-l border-gray-300 transition-colors">+</button>
                                </div>
                            </div>
                            
                            <div class="w-full sm:w-2/3 flex space-x-3">
                                <button type="submit" class="flex-1 h-12 bg-white border-2 border-primary text-primary font-bold rounded-lg hover:bg-primary/5 transition-colors flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    Add to Cart
                                </button>
                                <button type="submit" name="order_now" value="1" class="flex-1 h-12 bg-primary text-white font-bold rounded-lg hover:bg-red-600 shadow-lg shadow-red-500/30 transition-colors flex items-center justify-center">
                                    Order Now
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
