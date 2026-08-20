@extends('layouts.app')

@section('content')
<div class="bg-gray-50 py-12 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row gap-8">
            
            <!-- Sidebar -->
            <div class="w-full md:w-1/4">
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden sticky top-24">
                    <div class="p-6 border-b border-gray-100 text-center">
                        <div class="w-20 h-20 bg-primary/10 text-primary rounded-full flex items-center justify-center text-3xl font-bold mx-auto mb-4">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <h2 class="text-xl font-bold text-gray-900">{{ auth()->user()->name }}</h2>
                        <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                    </div>
                    <nav class="p-4 space-y-2">
                        <a href="{{ route('profile') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-xl font-medium transition-colors">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Profile Details
                        </a>
                        <a href="{{ route('orders.index') }}" class="flex items-center px-4 py-3 bg-primary text-white rounded-xl font-medium transition-colors">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            My Orders
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="w-full mt-4">
                            @csrf
                            <button type="submit" class="flex w-full items-center px-4 py-3 text-red-600 hover:bg-red-50 rounded-xl font-medium transition-colors">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                Sign Out
                            </button>
                        </form>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="w-full md:w-3/4">
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">My Orders</h2>
                    
                    @if($orders->isEmpty())
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">No orders yet</h3>
                            <p class="text-gray-500 mb-6">You haven't placed any orders.</p>
                            <a href="{{ route('menu.index') }}" class="inline-block px-6 py-3 bg-primary text-white font-bold rounded-full hover:bg-red-600 transition-colors">
                                Browse Menu
                            </a>
                        </div>
                    @else
                        <div class="space-y-6">
                            @foreach($orders as $order)
                                <div class="border border-gray-200 rounded-2xl overflow-hidden hover:border-gray-300 transition-colors">
                                    <div class="bg-gray-50 px-6 py-4 flex flex-col md:flex-row justify-between items-center border-b border-gray-200">
                                        <div class="flex space-x-8 w-full md:w-auto mb-4 md:mb-0">
                                            <div>
                                                <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1">Order Placed</p>
                                                <p class="text-sm font-medium text-gray-900">{{ $order->created_at->format('M d, Y') }}</p>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1">Total</p>
                                                <p class="text-sm font-medium text-gray-900">Rs. {{ number_format($order->total) }}</p>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1">Order #</p>
                                                <p class="text-sm font-medium text-gray-900">{{ $order->order_number }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center w-full md:w-auto justify-between md:justify-end">
                                            @php
                                                $statusColors = [
                                                    'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                                    'confirmed' => 'bg-blue-100 text-blue-800 border-blue-200',
                                                    'preparing' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                                                    'ready' => 'bg-purple-100 text-purple-800 border-purple-200',
                                                    'out_for_delivery' => 'bg-orange-100 text-orange-800 border-orange-200',
                                                    'delivered' => 'bg-green-100 text-green-800 border-green-200',
                                                    'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                                                ];
                                                $colorClass = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                                            @endphp
                                            <span class="px-3 py-1 rounded-full text-xs font-bold border capitalize {{ $colorClass }}">
                                                {{ str_replace('_', ' ', $order->status) }}
                                            </span>
                                            
                                            <a href="{{ route('orders.show', $order->order_number) }}" class="ml-4 text-sm font-medium text-primary hover:underline">
                                                View Details
                                            </a>
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
</div>
@endsection
