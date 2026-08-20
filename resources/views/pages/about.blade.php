@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="relative bg-gray-900 py-24">
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?q=80&w=2000&auto=format&fit=crop" class="w-full h-full object-cover opacity-30" alt="Restaurant interior">
    </div>
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-6">Our Story</h1>
        <p class="text-xl text-gray-300 max-w-3xl mx-auto">Discover the passion, history, and people behind DanishKada's premium culinary experience.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <div class="flex flex-col md:flex-row items-center gap-16">
        <div class="w-full md:w-1/2">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">A Journey of Flavors</h2>
            <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                Founded with a simple mission—to bring world-class, premium food to your table. DanishKada started as a small dream and has grown into a beloved culinary destination for food enthusiasts.
            </p>
            <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                We believe that great food brings people together. Our chefs use only the freshest ingredients, sourced locally where possible, to craft dishes that are not just meals, but experiences. From our signature burgers to our authentic pasta, every item on our menu is a testament to our dedication to quality.
            </p>
            
            <div class="grid grid-cols-2 gap-8">
                <div>
                    <h3 class="text-4xl font-bold text-primary mb-2">10+</h3>
                    <p class="text-gray-900 font-medium">Years of Experience</p>
                </div>
                <div>
                    <h3 class="text-4xl font-bold text-primary mb-2">50k+</h3>
                    <p class="text-gray-900 font-medium">Happy Customers</p>
                </div>
            </div>
        </div>
        <div class="w-full md:w-1/2">
            <div class="grid grid-cols-2 gap-4">
                <img src="https://images.unsplash.com/photo-1577219491135-ce391730fb2c?q=80&w=600&auto=format&fit=crop" class="rounded-3xl w-full h-64 object-cover" alt="Chef cooking">
                <img src="https://images.unsplash.com/photo-1600565193348-f74bd3c7ccdf?q=80&w=600&auto=format&fit=crop" class="rounded-3xl w-full h-64 object-cover mt-12" alt="Chef preparing ingredients">
            </div>
        </div>
    </div>
</div>

<div class="bg-gray-50 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold text-gray-900 mb-16">Our Core Values</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                <div class="w-16 h-16 bg-primary/10 text-primary rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Premium Quality</h3>
                <p class="text-gray-600">We never compromise on quality. Only the finest ingredients make it to our kitchen and onto your plate.</p>
            </div>
            
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                <div class="w-16 h-16 bg-primary/10 text-primary rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Fast Service</h3>
                <p class="text-gray-600">Your time is valuable. We strive to provide prompt service without ever sacrificing the quality of your food.</p>
            </div>
            
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                <div class="w-16 h-16 bg-primary/10 text-primary rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Customer Satisfaction</h3>
                <p class="text-gray-600">Seeing a smile on our customers' faces is our ultimate reward. We go above and beyond to ensure you are happy.</p>
            </div>
        </div>
    </div>
</div>
@endsection
