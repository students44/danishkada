@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="relative bg-gray-50 overflow-hidden h-[600px] flex items-center">
    <div class="absolute inset-0 z-0">
        <!-- Abstract gradient background -->
        <div class="absolute inset-0 bg-gradient-to-r from-gray-900 to-gray-800 opacity-90"></div>
        <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover mix-blend-overlay" alt="Food background">
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
        <div class="md:w-2/3">
            <span class="inline-block py-1 px-3 rounded-full bg-primary/20 text-primary border border-primary/30 text-sm font-semibold mb-6 uppercase tracking-wider">Premium Taste</span>
            <h1 class="text-5xl md:text-7xl font-bold text-white mb-6 leading-tight">
                Satisfy your <span class="text-primary">cravings</span> with every bite
            </h1>
            <p class="text-xl text-gray-300 mb-10 md:w-4/5">
                Experience the best premium food in town. Freshly prepared, passionately cooked, and delivered hot.
            </p>
            <div class="flex space-x-4">
                <a href="{{ route('menu.index') }}" class="px-8 py-4 bg-primary text-white rounded-full font-bold text-lg hover:bg-red-600 shadow-lg shadow-red-500/40 transition-all hover:-translate-y-1">
                    Order Now
                </a>
                <a href="{{ route('menu.index') }}" class="px-8 py-4 bg-white/10 text-white rounded-full font-bold text-lg hover:bg-white/20 backdrop-blur-sm border border-white/20 transition-all">
                    View Menu
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Categories Section -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <div class="flex justify-between items-end mb-12">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Explore Categories</h2>
            <p class="text-gray-500">Find exactly what you're looking for</p>
        </div>
        <a href="{{ route('menu.index') }}" class="text-primary font-semibold hover:underline hidden md:block">See all &rarr;</a>
    </div>
    
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        @foreach($categories as $category)
        <a href="{{ route('menu.index', ['category' => $category->slug]) }}" class="group relative rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 aspect-square">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent z-10"></div>
            @if($category->image)
                <img src="{{ asset('storage/' . $category->image) }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="{{ $category->name }}">
            @else
                <img src="https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?q=80&w=1000&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="{{ $category->name }}">
            @endif
            <div class="absolute bottom-0 left-0 w-full p-6 z-20">
                <h3 class="text-2xl font-bold text-white">{{ $category->name }}</h3>
            </div>
        </a>
        @endforeach
    </div>
</div>

<!-- Popular Dishes Section -->
<div class="bg-gray-50 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Popular Dishes</h2>
            <p class="text-gray-500 max-w-2xl mx-auto">Our most loved signature dishes that keep our customers coming back for more.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($popularProducts as $product)
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group border border-gray-100">
                <div class="relative h-56 overflow-hidden">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $product->name }}">
                    @else
                        <img src="https://images.unsplash.com/photo-1568901346375-23c9450c58cd?q=80&w=1000&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $product->name }}">
                    @endif
                    @if($product->discount_price)
                        <div class="absolute top-4 left-4 bg-primary text-white text-xs font-bold px-3 py-1 rounded-full">
                            Sale
                        </div>
                    @endif
                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur px-2 py-1 rounded-full flex items-center shadow-sm">
                        <span class="text-yellow-400 mr-1 text-sm">★</span>
                        <span class="text-xs font-bold text-gray-800">4.9</span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="text-sm text-primary font-semibold mb-2">{{ $product->category->name }}</div>
                    <a href="{{ route('menu.show', $product->slug) }}" class="block text-xl font-bold text-gray-900 mb-2 hover:text-primary transition-colors">{{ $product->name }}</a>
                    <p class="text-gray-500 text-sm mb-6 line-clamp-2">{{ $product->description }}</p>
                    <div class="flex justify-between items-center mt-auto">
                        <div>
                            @if($product->discount_price)
                                <span class="text-gray-400 line-through text-sm mr-2">Rs. {{ number_format($product->price) }}</span>
                                <span class="text-2xl font-bold text-gray-900">Rs. {{ number_format($product->discount_price) }}</span>
                            @else
                                <span class="text-2xl font-bold text-gray-900">Rs. {{ number_format($product->price) }}</span>
                            @endif
                        </div>
                        <a href="{{ route('menu.show', $product->slug) }}" class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-700 hover:bg-primary hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('menu.index') }}" class="inline-flex items-center px-8 py-4 border-2 border-gray-900 text-lg font-bold rounded-full text-gray-900 hover:bg-gray-900 hover:text-white transition-all">
                View Full Menu
            </a>
        </div>
    </div>
</div>

@endsection
