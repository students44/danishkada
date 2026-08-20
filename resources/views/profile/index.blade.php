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
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <h2 class="text-xl font-bold text-gray-900">{{ $user->name }}</h2>
                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                    </div>
                    <nav class="p-4 space-y-2">
                        <a href="{{ route('profile') }}" class="flex items-center px-4 py-3 bg-primary text-white rounded-xl font-medium transition-colors">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Profile Details
                        </a>
                        <a href="{{ route('orders.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-xl font-medium transition-colors">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
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
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">Profile Details</h2>
                    
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        <div class="space-y-6 max-w-lg">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                <input type="text" name="name" value="{{ $user->name }}" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                <input type="email" name="email" value="{{ $user->email }}" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary">
                            </div>
                            
                            <button type="submit" class="px-8 py-3 bg-gray-900 text-white font-bold rounded-xl hover:bg-gray-800 transition-colors shadow-lg">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
