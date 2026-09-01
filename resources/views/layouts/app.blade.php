<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danish Kada - Restaurant</title>
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#ff4c3b', // A premium red/orange color for food
                        secondary: '#1a1a1a', // Dark modern color
                    }
                }
            }
        }
    </script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f9f9f9;
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body class="antialiased text-gray-800 overflow-x-hidden">
    <!-- Navbar -->
    <nav class="fixed w-full z-[100] glass-effect transition-all duration-300" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-3xl font-bold text-primary tracking-tight">
                        Danish<span class="text-secondary">Kada</span>
                    </a>
                </div>
                <div class="hidden md:flex space-x-8 items-center">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-primary font-medium transition-colors">Home</a>
                    <a href="{{ route('menu.index') }}" class="text-gray-700 hover:text-primary font-medium transition-colors">Menu</a>
                    <a href="{{ route('about') }}" class="text-gray-700 hover:text-primary font-medium transition-colors">About</a>
                    <a href="{{ route('contact') }}" class="text-gray-700 hover:text-primary font-medium transition-colors">Contact</a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-600 hover:text-primary transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        @php
                            $cartCount = 0;
                            if (session()->has('id')) {
                                $cart = \App\Models\Cart::where('session_id', session()->getId())->first();
                                if ($cart) $cartCount = $cart->items->sum('quantity');
                            }
                        @endphp
                        @if($cartCount > 0)
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-primary rounded-full">{{ $cartCount }}</span>
                        @endif
                    </a>
                    
                    @auth
                        <a href="{{ route('profile') }}" class="hidden md:inline-flex items-center justify-center px-6 py-2.5 border border-primary text-sm font-semibold rounded-full text-primary hover:bg-primary hover:text-white transition-all duration-300">
                            My Account
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="hidden md:inline-flex items-center justify-center px-6 py-2.5 border border-transparent text-sm font-semibold rounded-full text-white bg-primary hover:bg-red-600 shadow-lg shadow-red-500/30 transition-all duration-300">
                            Login
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="min-h-screen pt-20">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-secondary text-white py-12 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-2xl font-bold text-primary mb-4">DanishKada</h3>
                <p class="text-gray-400">Serving the best premium food in town. Taste the difference.</p>
            </div>
            <div>
                <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="{{ route('home') }}" class="hover:text-primary transition-colors">Home</a></li>
                    <li><a href="{{ route('menu.index') }}" class="hover:text-primary transition-colors">Menu</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-primary transition-colors">About Us</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-primary transition-colors">Contact</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-lg font-semibold mb-4">Contact Info</h4>
                <ul class="space-y-2 text-gray-400">
                    <li>123 Food Street, City</li>
                    <li>+1 234 567 8900</li>
                    <li>info@danishkada.com</li>
                </ul>
            </div>
            <div>
                <h4 class="text-lg font-semibold mb-4">Opening Hours</h4>
                <ul class="space-y-2 text-gray-400">
                    <li>Mon - Fri: 10am - 11pm</li>
                    <li>Sat - Sun: 9am - 12am</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-700 mt-12 pt-8 text-center text-gray-500">
            <p>&copy; {{ date('Y') }} Danish Kada. All rights reserved.</p>
        </div>
    </footer>

    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true,
            offset: 100,
            easing: 'ease-out-cubic',
        });

        // Navbar Scroll Effect
        window.addEventListener('scroll', function() {
            var navbar = document.getElementById('navbar');
            if (window.scrollY > 10) {
                navbar.classList.add('py-0');
                navbar.classList.remove('py-2');
            } else {
                navbar.classList.add('py-2');
                navbar.classList.remove('py-0');
            }
        });
    </script>
</body>
</html>
