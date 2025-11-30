{{-- resources/views/components/layout/sidebar-organizer.blade.php --}}
<div class="w-64 bg-gradient-to-b from-gray-900 to-gray-800 text-white flex flex-col">
    <!-- Sidebar Header -->
    <div class="p-6 border-b border-gray-700">
        <div class="flex items-center">
             <div class="w-11 h-11bg-gradient-to-r from-[#262363] to-[#262363] rounded-lg flex items-center justify-center">
                <i class="fas fa-briefcase text-white"></i>
            </div>
            <div>
                <h2 class="text-lg font-bold">Organizer Panel</h2>
                <p class="text-gray-400 text-sm">Event Management</p>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 px-4 py-6 space-y-2">
        <!-- Dashboard -->
        <a href="{{ route('organizer.dashboard') }}" 
           class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-xl transition-all duration-200 {{ request()->routeIs('organizer.dashboard') ? 'bg-gray-700 text-white' : '' }}">
            <i class="fas fa-home mr-3 text-lg"></i>
            <span class="font-medium">Dashboard</span>
        </a>

        <!-- My Events -->
        <a href="{{ route('organizer.events.index') }}" 
           class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-xl transition-all duration-200 {{ request()->routeIs('organizer.events.*') ? 'bg-gray-700 text-white' : '' }}">
            <i class="fas fa-calendar-alt mr-3 text-lg"></i>
            <span class="font-medium">Acara Saya</span>
        </a>

        <!-- Create Event -->
        <a href="{{ route('organizer.events.create') }}" 
           class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-xl transition-all duration-200 {{ request()->routeIs('organizer.events.create') ? 'bg-gray-700 text-white' : '' }}">
            <i class="fas fa-plus-circle mr-3 text-lg"></i>
            <span class="font-medium">Buat Acara</span>
        </a>

        <!-- Bookings -->
        <a href="{{ route('organizer.bookings.index') }}" 
           class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-xl transition-all duration-200 {{ request()->routeIs('organizer.bookings.*') ? 'bg-gray-700 text-white' : '' }}">
            <i class="fas fa-ticket-alt mr-3 text-lg"></i>
            <span class="font-medium">Pemesanan </span>
        </a>

        <!-- Analytics -->
        <a href="{{ route('organizer.analytics.index') }}" 
           class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-xl transition-all duration-200 {{ request()->routeIs('organizer.analytics.*') ? 'bg-gray-700 text-white' : '' }}">
            <i class="fas fa-chart-line mr-3 text-lg"></i>
            <span class="font-medium">Analitik</span>
        </a>
    </nav>

    <!-- Sidebar Footer -->
    <div class="p-4 border-t border-gray-700">
        <div class="bg-gray-800 rounded-xl p-3 flex items-center gap-3">
            @if(auth()->user()->profile_image)
                <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" 
                     alt="{{ auth()->user()->name }}" 
                     class="w-10 h-10 rounded-full object-cover">
            @else
                <div class="w-10 h-10 bg-gradient-to-r from-[#35ac60]  to-[#35ac60] rounded-full flex items-center justify-center text-white font-semibold">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
            @endif
            <div>
                <div class="text-xs text-gray-400 mb-1">Masuk Sebagai</div>
                <div class="font-medium text-white">{{ auth()->user()->name }}</div>
                <div class="text-xs text-gray-400">Organizer</div>
            </div>
        </div>
    </div>
</div>

