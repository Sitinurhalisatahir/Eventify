<nav class="bg-[#262363] shadow-lg sticky top-0 z-50" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo & Brand -->
            <div class="flex items-center">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo" style="width: 150px; height: auto;">
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-8">
                <!-- Home - Pink saat di halaman home -->
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-[#e692b7]' : 'text-white' }} hover:text-[#e692b7] font-medium transition-colors">
                    <i class="fas fa-home mr-2"></i> Beranda
                </a>

                <!-- Events - Pink saat di halaman events -->
                <a href="{{ route('events.index') }}" class="{{ request()->routeIs('events.*') ? 'text-[#e692b7]' : 'text-white' }} hover:text-[#e692b7] font-medium transition-colors">
                    <i class="fas fa-calendar-alt mr-2"></i> Acara
                </a>

                @auth
                    @if(auth()->user()->role === 'admin')
                        <!-- Admin - Pink saat di halaman admin -->
                        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.*') ? 'text-[#e692b7]' : 'text-white' }} hover:text-[#e692b7] font-medium transition-colors">
                            <i class="fas fa-tachometer-alt mr-2"></i> Admin
                        </a>
                    @elseif(auth()->user()->role === 'organizer')
                        <!-- Organizer - Pink saat di halaman organizer -->
                        <a href="{{ route('organizer.dashboard') }}" class="{{ request()->routeIs('organizer.*') ? 'text-[#e692b7]' : 'text-white' }} hover:text-[#e692b7] font-medium transition-colors">
                            <i class="fas fa-briefcase mr-2"></i> Organizer
                        </a>
                    @else
                        <!-- User Dashboard - Pink saat di dashboard user -->
                        <a href="{{ route('user.dashboard') }}" class="{{ request()->routeIs('user.dashboard') ? 'text-[#e692b7]' : 'text-white' }} hover:text-[#e692b7] font-medium transition-colors">
                            <i class="fas fa-user mr-2"></i> Dashboard
                        </a>

                        <!-- Favorites - Pink saat di halaman favorites -->
                        <a href="{{ route('user.favorites.index') }}" class="{{ request()->routeIs('user.favorites.*') ? 'text-[#e692b7]' : 'text-white' }} hover:text-[#e692b7] font-medium transition-colors">
                            <i class="fas fa-heart mr-2"></i> Favorit
                        </a>
                    @endif
                @endauth
            </div>

            <!-- Auth Buttons -->
            <div class="hidden md:flex items-center space-x-4">
                @guest
                    <a href="{{ route('login') }}" class="text-white hover:text-[#e692b7] font-medium transition-colors">
                        <i class="fas fa-sign-in-alt mr-2"></i> Masuk
                    </a>
                    <a href="{{ route('register') }}" class="bg-[#e6527b] text-white px-6 py-2 rounded-xl hover:bg-[#d9416d] font-semibold transition-all duration-300 shadow-lg">
                        <i class="fas fa-user-plus mr-2"></i> Daftar
                    </a>
                @else
                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-2 text-white hover:text-[#e692b7] transition-colors">
                            @if(auth()->user()->profile_image)
                                <img src="{{ asset('storage/' . auth()->user()->profile_image)}}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full object-cover">
                            @else
                                <div class="w-8 h-8 bg-[#e6527b] rounded-full flex items-center justify-center text-white font-semibold">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                            @endif
                            <span class="font-medium">{{ auth()->user()->name }}</span>
                            <i class="fas fa-chevron-down text-sm"></i>
                        </button>

                        <div x-show="open" @click.away="open = false" 
                             class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-2 z-50 border border-gray-100"
                             style="display: none;">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-user-edit mr-2"></i> Edit Profile
                            </a>
                            @if(auth()->user()->role === 'user')
                                <a href="{{ route('user.bookings.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-ticket-alt mr-2"></i> My Bookings
                                </a>
                            @endif
                            <hr class="my-2 border-gray-100">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 transition-colors">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden flex items-center">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-white hover:text-[#e692b7] transition-colors">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false" class="md:hidden bg-white border-t border-gray-100" style="display: none;">
        <div class="px-4 pt-2 pb-4 space-y-2">
            <!-- Mobile links juga bisa ditambahkan active state jika mau -->
            <a href="{{ route('home') }}" class="block py-3 text-gray-700 hover:text-[#e6527b] font-medium transition-colors border-b border-gray-100">
                <i class="fas fa-home mr-3"></i>Beranda
            </a>
            <a href="{{ route('events.index') }}" class="block py-3 text-gray-700 hover:text-[#e6527b] font-medium transition-colors border-b border-gray-100">
                <i class="fas fa-calendar-alt mr-3"></i>Acara
            </a>

            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="block py-3 text-gray-700 hover:text-[#e6527b] font-medium transition-colors border-b border-gray-100">
                        <i class="fas fa-tachometer-alt mr-3"></i> Admin Dashboard
                    </a>
                @elseif(auth()->user()->role === 'organizer')
                    <a href="{{ route('organizer.dashboard') }}" class="block py-3 text-gray-700 hover:text-[#e6527b] font-medium transition-colors border-b border-gray-100">
                        <i class="fas fa-briefcase mr-3"></i> Organizer Dashboard
                    </a>
                @else
                    <a href="{{ route('user.dashboard') }}" class="block py-3 text-gray-700 hover:text-[#e6527b] font-medium transition-colors border-b border-gray-100">
                        <i class="fas fa-user mr-3"></i> My Dashboard
                    </a>
                    <a href="{{ route('user.favorites.index') }}" class="block py-3 text-gray-700 hover:text-[#e6527b] font-medium transition-colors border-b border-gray-100">
                        <i class="fas fa-heart mr-3"></i> Favorites
                    </a>
                    <a href="{{ route('user.bookings.index') }}" class="block py-3 text-gray-700 hover:text-[#e6527b] font-medium transition-colors border-b border-gray-100">
                        <i class="fas fa-ticket-alt mr-3"></i> My Bookings
                    </a>
                @endif

                <hr class="my-2 border-gray-100">
                <a href="{{ route('profile.edit') }}" class="block py-3 text-gray-700 hover:text-[#e6527b] font-medium transition-colors border-b border-gray-100">
                    <i class="fas fa-user-edit mr-3"></i> Edit Profile
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left py-3 text-red-600 hover:text-red-700 font-medium transition-colors">
                        <i class="fas fa-sign-out-alt mr-3"></i> Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block py-3 text-gray-700 hover:text-[#e6527b] font-medium transition-colors border-b border-gray-100">
                    <i class="fas fa-sign-in-alt mr-3"></i> Login
                </a>
                <a href="{{ route('register') }}" class="block py-3 bg-[#e6527b] text-white rounded-xl text-center hover:bg-[#d9416d] font-semibold transition-all duration-300 mt-2">
                    <i class="fas fa-user-plus mr-3"></i> Register
                </a>
            @endguest
        </div>
    </div>
</nav>