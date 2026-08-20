@extends('layouts.app')

@section('content')
<div class="bg-gray-50 py-12 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Back link -->
        <a href="{{ route('orders.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-primary mb-8 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Orders
        </a>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Order Header -->
            <div class="bg-gray-50 border-b border-gray-200 p-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 mb-1">Order #{{ $order->order_number }}</h1>
                        <p class="text-gray-500">Placed on {{ $order->created_at->format('M d, Y \a\t h:i A') }}</p>
                    </div>
                    
                    <div class="mt-4 md:mt-0 flex flex-col items-start md:items-end">
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
                        <span class="px-4 py-1.5 rounded-full text-sm font-bold border capitalize {{ $colorClass }} mb-2">
                            {{ str_replace('_', ' ', $order->status) }}
                        </span>
                        
                        <a href="#" class="text-sm text-primary hover:underline font-medium flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Download Invoice
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tracking Progress (Visual) -->
            <div class="p-8 border-b border-gray-200">
                <div class="max-w-3xl mx-auto">
                    @php
                        $statuses = ['pending', 'confirmed', 'preparing', 'out_for_delivery', 'delivered'];
                        $currentIndex = array_search($order->status, $statuses);
                        if ($currentIndex === false) $currentIndex = 0; // fallback
                        
                        if ($order->status == 'cancelled') {
                            $currentIndex = -1;
                        }
                    @endphp
                    
                    @if($order->status != 'cancelled')
                    <div class="relative">
                        <div class="overflow-hidden h-2 mb-4 text-xs flex rounded-full bg-gray-200">
                            <div style="width: {{ ($currentIndex / (count($statuses) - 1)) * 100 }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-primary transition-all duration-500"></div>
                        </div>
                        <div class="flex justify-between text-xs font-medium text-gray-500">
                            <span class="{{ $currentIndex >= 0 ? 'text-primary font-bold' : '' }}">Received</span>
                            <span class="{{ $currentIndex >= 1 ? 'text-primary font-bold' : '' }}">Confirmed</span>
                            <span class="{{ $currentIndex >= 2 ? 'text-primary font-bold' : '' }}">Preparing</span>
                            <span class="{{ $currentIndex >= 3 ? 'text-primary font-bold' : '' }}">On the way</span>
                            <span class="{{ $currentIndex >= 4 ? 'text-primary font-bold' : '' }}">Delivered</span>
                        </div>
                    </div>
                    @else
                        <div class="bg-red-50 text-red-600 p-4 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="font-bold">This order was cancelled.</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Order Details -->
            <div class="p-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <h2 class="text-lg font-bold text-gray-900 mb-6">Items</h2>
                    
                    <ul class="divide-y divide-gray-200">
                        @foreach($order->items as $item)
                        <li class="py-4 flex flex-col sm:flex-row">
                            <div class="flex-shrink-0 w-20 h-20 bg-gray-100 rounded-xl overflow-hidden mb-4 sm:mb-0">
                                @if($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover">
                                @else
                                    <img src="https://images.unsplash.com/photo-1568901346375-23c9450c58cd?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="sm:ml-4 flex-1 flex flex-col justify-center">
                                <div class="flex justify-between">
                                    <h3 class="text-base font-bold text-gray-900"><a href="{{ route('menu.show', $item->product->slug) }}">{{ $item->product->name }}</a></h3>
                                    <p class="text-base font-bold text-gray-900">Rs. {{ number_format($item->price * $item->quantity) }}</p>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">Qty: {{ $item->quantity }} x Rs. {{ number_format($item->price) }}</p>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                
                <div>
                    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200 mb-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Summary</h2>
                        <dl class="text-sm text-gray-600 space-y-3">
                            <div class="flex justify-between">
                                <dt>Subtotal</dt>
                                <dd class="font-medium text-gray-900">Rs. {{ number_format($order->subtotal) }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt>Delivery Fee</dt>
                                <dd class="font-medium text-gray-900">Rs. {{ number_format($order->delivery_fee) }}</dd>
                            </div>
                            <div class="flex justify-between border-t border-gray-200 pt-3 mt-3">
                                <dt class="text-base font-bold text-gray-900">Total</dt>
                                <dd class="text-xl font-bold text-primary">Rs. {{ number_format($order->total) }}</dd>
                            </div>
                        </dl>
                    </div>
                    
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Payment</h2>
                    <p class="text-gray-600 mb-6 capitalize">
                        {{ str_replace('_', ' ', $order->payment_method) }}
                        <span class="inline-flex ml-2 px-2 py-0.5 rounded text-xs font-medium {{ $order->payment_status == 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $order->payment_status }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
