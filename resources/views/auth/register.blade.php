@extends('layouts.app')

@section('content')
<div class="bg-gray-50 py-20 min-h-[calc(100vh-100px)] flex items-center justify-center">
    <div class="max-w-md w-full mx-auto px-4">
        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8">
            <div class="text-center mb-10">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Create Account</h1>
                <p class="text-gray-500">Join DanishKada for a premium experience</p>
            </div>

            @if($errors->any())
                <div class="bg-red-50 text-red-500 p-4 rounded-xl mb-6 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input type="password" name="password" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                        <input type="password" name="password_confirmation" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors">
                    </div>

                    <button type="submit" class="w-full py-4 bg-primary text-white font-bold rounded-xl hover:bg-red-600 transition-colors shadow-lg shadow-red-500/30">
                        Sign Up
                    </button>
                </div>
            </form>
            
            <div class="mt-8 text-center text-sm text-gray-600">
                Already have an account? <a href="{{ route('login') }}" class="font-bold text-primary hover:underline">Sign In</a>
            </div>
        </div>
    </div>
</div>
@endsection
