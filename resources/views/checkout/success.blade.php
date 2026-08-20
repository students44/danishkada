@extends('layouts.app')

@section('content')
<div class="bg-gray-50 py-20 min-h-screen flex items-center justify-center">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-12 text-center relative overflow-hidden">
            <!-- Decorative Background -->
            <div class="absolute top-0 left-0 w-full h-2 bg-green-500"></div>
            
            <div class="w-24 h-24 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-8 shadow-sm">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            </div>
            
            <h1 class="text-4xl font-bold text-gray-900 mb-4">🎉 Order Successfully Placed!</h1>
            <p class="text-xl text-gray-500 mb-8">Thank you for your order. We are preparing it now.</p>
            
            <div class="bg-gray-50 rounded-2xl p-8 mb-8 text-left border border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Order Number</p>
                        <p class="text-lg font-bold text-gray-900">{{ $order->order_number }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Total Amount</p>
                        <p class="text-lg font-bold text-primary">Rs. {{ number_format($order->total) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Payment Method</p>
                        <p class="text-lg font-bold text-gray-900 capitalize">{{ $order->payment_method }} ({{ $order->payment_status }})</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Estimated Delivery</p>
                        <p class="text-lg font-bold text-gray-900">30 - 45 Minutes</p>
                    </div>
                </div>
                
                <hr class="my-6 border-gray-200">
                
                <h3 class="font-bold text-gray-900 mb-4">Delivery Address</h3>
                <p class="text-gray-600">
                    {{ $order->address->full_name }}<br>
                    {{ $order->address->address }}, {{ $order->address->area }}<br>
                    {{ $order->address->city }}<br>
                    {{ $order->address->phone }}
                </p>
            </div>
            
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="#" class="px-8 py-3 bg-gray-900 text-white font-bold rounded-full hover:bg-gray-800 transition-colors">
                    Track Order
                </a>
                <a href="{{ route('home') }}" class="px-8 py-3 bg-white border-2 border-gray-200 text-gray-700 font-bold rounded-full hover:bg-gray-50 hover:border-gray-300 transition-colors">
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
