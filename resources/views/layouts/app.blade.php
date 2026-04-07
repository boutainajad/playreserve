<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PlayReserve — @yield('title')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        playtomic: {
                            blue: '#3461ff',
                            lime: '#ccf600',
                            limedark: '#b8de00',
                            dark: '#121212',
                            bg: '#f8f9fb',
                            text: '#222222'
                        }
                    },
                    fontFamily: { sans: ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>
    
    @stack('styles')
</head>
<body class="font-sans text-playtomic-text bg-playtomic-bg antialiased flex flex-col min-h-screen">

    <nav class="hidden md:flex sticky top-0 z-50 bg-white border-b border-gray-100 items-center w-full px-6 lg:px-12 py-4 h-[72px]">
        <div class="max-w-[1440px] mx-auto w-full flex items-center justify-between">
            <a class="flex items-center gap-2 text-playtomic-blue font-black text-xl tracking-wider uppercase" href="{{ auth()->check() ? route('dashboard') : route('home') }}">
                <i class="bi bi-layers h-6 text-2xl flex items-center"></i> PLAYRESERVE
            </a>

            @auth
            <ul class="flex items-center gap-6 ml-12 font-semibold text-[15px] text-gray-500">
                @if(auth()->user()->role === 'admin')
                    <li><a class="hover:text-playtomic-blue transition-colors px-2 py-1 {{ request()->routeIs('admin.dashboard') ? 'text-playtomic-blue' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                @elseif(auth()->user()->role === 'owner')
                    <li><a class="hover:text-playtomic-blue transition-colors px-2 py-1 {{ request()->routeIs('owner.dashboard') ? 'text-playtomic-blue' : '' }}" href="{{ route('owner.dashboard') }}">Dashboard</a></li>
                    <li><a class="hover:text-playtomic-blue transition-colors px-2 py-1" href="#">Courts</a></li>
                @else
                    <li><a class="hover:text-playtomic-blue transition-colors px-2 py-1 {{ request()->routeIs('dashboard') ? 'text-playtomic-blue' : '' }}" href="{{ route('dashboard') }}">Explore</a></li>
                    <li><a class="hover:text-playtomic-blue transition-colors px-2 py-1 {{ request()->routeIs('reservations.history') ? 'text-playtomic-blue' : '' }}" href="{{ route('reservations.history') }}">Matches</a></li>
                @endif
            </ul>
            @endauth

            <div class="ml-auto flex items-center gap-4">
                @auth
                    <div class="relative group cursor-pointer">
                        <div class="w-10 h-10 rounded-full bg-playtomic-blue text-white flex items-center justify-center font-bold text-lg hover:shadow-lg hover:shadow-playtomic-blue/30 transition-all">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="absolute right-0 mt-2 w-56 bg-white border border-gray-100 rounded-2xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 p-2 z-50">
                            <div class="px-3 py-3 border-b border-gray-100 mb-2">
                                <div class="font-bold text-[15px] text-playtomic-text truncate">{{ auth()->user()->name }}</div>
                                <div class="text-xs text-gray-500 font-medium truncate">{{ auth()->user()->email }}</div>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-3 py-2 text-sm text-red-500 font-semibold hover:bg-gray-50 rounded-xl transition-colors flex items-center gap-2">
                                    <i class="bi bi-box-arrow-right"></i> Log out
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a class="text-sm font-bold text-gray-500 hover:text-playtomic-blue transition-colors" href="{{ route('login') }}">Log in</a>
                    <a class="ml-2 flex items-center justify-center gap-2 bg-playtomic-blue text-white px-5 py-2.5 rounded-full font-bold hover:bg-blue-700 transition-colors shadow-md shadow-playtomic-blue/20" href="{{ route('register') }}">
                        Sign up
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="md:hidden flex items-center justify-between px-4 h-16 bg-white sticky top-0 z-40 border-b border-gray-100 shadow-sm">
        <a class="flex items-center gap-2 text-playtomic-blue font-black text-lg uppercase" href="{{ route('home') }}">
            <i class="bi bi-layers"></i> PLAYRESERVE
        </a>
        @auth
        <div class="w-9 h-9 rounded-full bg-playtomic-blue text-white flex items-center justify-center font-bold text-sm">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
        @endauth
    </div>

    <main class="flex-1 w-full max-w-[1240px] mx-auto md:p-8 p-4 md:pb-20 pb-28">
        @if(session('success'))
            <div class="flex items-center gap-3 p-4 mb-8 rounded-2xl bg-playtomic-lime/20 border border-playtomic-lime text-[#6A8100]">
                <i class="bi bi-check-circle-fill text-xl"></i>
                <p class="text-[15px] font-bold">{{ session('success') }}</p>
            </div>
        @endif
        @if(session('error'))
            <div class="flex items-center gap-3 p-4 mb-8 rounded-2xl bg-red-50 border border-red-100 text-red-600">
                <i class="bi bi-exclamation-octagon-fill text-xl"></i>
                <p class="text-[15px] font-bold">{{ session('error') }}</p>
            </div>
        @endif

        @yield('content')
    </main>

    <nav class="md:hidden fixed bottom-0 left-0 w-full h-16 bg-white border-t border-gray-200 flex justify-around items-center z-50 pb-safe shadow-[0_-4px_10px_rgba(0,0,0,0.03)]">
        @auth
            <a href="{{ route('home') }}" class="flex flex-col items-center justify-center w-full h-full text-gray-400 hover:text-playtomic-blue {{ request()->routeIs('home') ? 'text-playtomic-blue' : '' }} transition-colors relative">
                @if(request()->routeIs('home')) <div class="absolute top-0 w-8 h-1 bg-playtomic-blue rounded-b-md"></div> @endif
                <i class="bi bi-house-door-fill text-xl mb-0.5"></i>
                <span class="text-[10px] font-bold">Home</span>
            </a>
            <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center w-full h-full text-gray-400 hover:text-playtomic-blue {{ request()->routeIs('dashboard') ? 'text-playtomic-blue' : '' }} transition-colors relative">
                @if(request()->routeIs('dashboard')) <div class="absolute top-0 w-8 h-1 bg-playtomic-blue rounded-b-md"></div> @endif
                <i class="bi bi-search text-xl mb-0.5"></i>
                <span class="text-[10px] font-bold">Explore</span>
            </a>
            <a href="{{ route('reservations.history') }}" class="flex flex-col items-center justify-center w-full h-full text-gray-400 hover:text-playtomic-blue {{ request()->routeIs('reservations.history') ? 'text-playtomic-blue' : '' }} transition-colors relative">
                @if(request()->routeIs('reservations.history')) <div class="absolute top-0 w-8 h-1 bg-playtomic-blue rounded-b-md"></div> @endif
                <i class="bi bi-calendar-check-fill text-xl mb-0.5"></i>
                <span class="text-[10px] font-bold">Matches</span>
            </a>
            <div class="flex flex-col items-center justify-center w-full h-full text-gray-400 cursor-pointer hover:text-playtomic-blue transition-colors" onclick="document.getElementById('mobile-logout').submit();">
                <i class="bi bi-box-arrow-right text-xl mb-0.5 text-red-400"></i>
                <span class="text-[10px] font-bold text-red-400">Log out</span>
                <form id="mobile-logout" method="POST" action="{{ route('logout') }}" class="hidden">@csrf</form>
            </div>
        @else
            <a href="{{ route('login') }}" class="flex flex-col items-center justify-center w-full h-full text-gray-500 font-bold text-[13px] hover:text-playtomic-blue">
                Log in
            </a>
            <a href="{{ route('register') }}" class="flex items-center justify-center w-full h-full p-2">
                <div class="w-full bg-playtomic-blue text-white font-bold text-[14px] py-2.5 rounded-full text-center shadow-md shadow-playtomic-blue/20">
                    Sign up
                </div>
            </a>
        @endauth
    </nav>

    <footer class="hidden md:block bg-[#0B1526] text-white py-16 mt-auto">
        <div class="max-w-[1240px] mx-auto px-6 lg:px-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                <div class="lg:col-span-1">
                    <a href="#" class="flex items-center gap-2 text-white font-black text-xl tracking-wider uppercase mb-6">
                        <i class="bi bi-layers h-6 text-2xl flex items-center text-playtomic-lime"></i> PLAYRESERVE
                    </a>
                    <p class="text-gray-400 text-sm leading-relaxed mb-6 font-medium">
                        Join the fastest-growing community of multi-sport players. Find courts for Football, Basketball, Volleyball and more.
                    </p>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-6">PlayReserve</h4>
                    <ul class="space-y-4 text-sm text-gray-400 font-medium">
                        <li><a href="#" class="hover:text-white transition-colors">Download our app</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">About Us</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-6">For Partners</h4>
                    <ul class="space-y-4 text-sm text-gray-400 font-medium">
                        <li><a href="{{ route('register.owner') }}" class="hover:text-playtomic-lime transition-colors text-playtomic-lime font-bold">Add your club</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Pricing</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-6">Legal</h4>
                    <ul class="space-y-4 text-sm text-gray-400 font-medium">
                        <li><a href="#" class="hover:text-white transition-colors">Terms of Service</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
            <div class="pt-8 border-t border-white/10 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-gray-400 text-sm font-medium">© {{ date('Y') }} PlayReserve. All rights reserved.</p>
                <div class="flex items-center gap-2 text-sm text-gray-400 font-medium">
                    Made with <i class="bi bi-heart-fill text-playtomic-lime"></i> for multi-sport lovers
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>