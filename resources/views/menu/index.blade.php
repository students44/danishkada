@extends('layouts.app')

@section('content')
<div class="bg-white">
    <!-- Header -->
    <div class="bg-secondary text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Our Menu</h1>
            <p class="text-gray-400 max-w-2xl mx-auto">Discover our delicious offerings. Filter by categories or search for your favorite dish.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Sidebar / Filters -->
            <div class="w-full md:w-1/4">
                <div class="bg-gray-50 p-6 rounded-2xl sticky top-24">
                    <form action="{{ route('menu.index') }}" method="GET">
                        <div class="mb-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Search</h3>
                            <div class="relative">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search food..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary">
                                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Categories</h3>
                            <div class="space-y-3">
                                <a href="{{ route('menu.index') }}" class="flex items-center justify-between group">
                                    <span class="text-gray-600 hover:text-primary {{ !request('category') ? 'font-bold text-primary' : '' }}">All Menu</span>
                                </a>
                                @foreach($categories as $category)
                                <a href="{{ route('menu.index', ['category' => $category->slug]) }}" class="flex items-center justify-between group">
                                    <span class="text-gray-600 hover:text-primary {{ request('category') == $category->slug ? 'font-bold text-primary' : '' }}">{{ $category->name }}</span>
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Menu Grid -->
            <div class="w-full md:w-3/4">
                @if($products->isEmpty())
                    <div class="text-center py-20 bg-gray-50 rounded-3xl">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">No food items found</h3>
                        <p class="text-gray-500">Try adjusting your filters or search criteria.</p>
                        <a href="{{ route('menu.index') }}" class="inline-block mt-4 text-primary font-semibold hover:underline">Clear all filters</a>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach($products as $product)
                        <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col">
                            <div class="relative h-48 overflow-hidden">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover" alt="{{ $product->name }}">
                                @else
                                    <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?q=80&w=1000&auto=format&fit=crop" class="w-full h-full object-cover" alt="{{ $product->name }}">
                                @endif
                                
                                @if($product->discount_price)
                                    <div class="absolute top-3 left-3 bg-primary text-white text-xs font-bold px-2 py-1 rounded-md">
                                        Sale
                                    </div>
                                @endif
                            </div>
                            <div class="p-5 flex-1 flex flex-col">
                                <div class="text-xs text-primary font-bold tracking-wider uppercase mb-1">{{ $product->category->name }}</div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $product->name }}</h3>
                                <p class="text-gray-500 text-sm mb-4 flex-1 line-clamp-2">{{ $product->description }}</p>
                                
                                <div class="flex justify-between items-center mt-auto pt-4 border-t border-gray-100">
                                    <div class="flex flex-col">
                                        @if($product->discount_price)
                                            <span class="text-gray-400 line-through text-xs">Rs. {{ number_format($product->price) }}</span>
                                            <span class="text-xl font-bold text-gray-900">Rs. {{ number_format($product->discount_price) }}</span>
                                        @else
                                            <span class="text-xl font-bold text-gray-900">Rs. {{ number_format($product->price) }}</span>
                                        @endif
                                    </div>
                                    <div class="flex space-x-2">
                                        <button class="p-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-primary hover:text-white transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        </button>
                                        <a href="{{ route('menu.show', $product->slug) }}" class="p-2 bg-primary text-white rounded-lg hover:bg-red-600 transition-colors">
                                            Order
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
