{{-- resources/views/components/layout/sidebar-admin.blade.php --}}
<div class="w-64 bg-gradient-to-b from-gray-900 to-gray-800 text-white flex flex-col">
    <!-- Header Sidebar -->
    <div class="p-6 border-b border-gray-700">
        <div class="flex items-center">
            <div class="w-10 h-10 bg-gradient-to-r from-[#262363] to-[#262363] rounded-lg flex items-center justify-center mr-3">
                <i class="fas fa-tachometer-alt text-white"></i>
            </div>
            <div>
                <h2 class="text-lg font-bold">Panel Admin</h2>
                <p class="text-gray-400 text-sm">Manajemen Acara</p>
            </div>
        </div>
    </div>

    <!-- Menu Navigasi -->
    <nav class="flex-1 px-4 py-6 space-y-2">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" 
           class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700 text-white' : '' }}">
            <i class="fas fa-home mr-3 text-lg"></i>
            <span class="font-medium">Dashboard</span>
        </a>

        <!-- Manajemen Pengguna -->
        <a href="{{ route('admin.users.index') }}" 
           class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-xl transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-gray-700 text-white' : '' }}">
            <i class="fas fa-users mr-3 text-lg"></i>
            <span class="font-medium">Manajemen Pengguna</span>
        </a>

        <!-- Persetujuan Organizer -->
        <a href="{{ route('admin.organizers.approval') }}" 
        class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-xl transition-all duration-200 {{ request()->routeIs('admin.organizers.*') ? 'bg-gray-700 text-white' : '' }}">
        <i class="fas fa-user-check mr-3 text-lg"></i>
        <span class="font-medium">Persetujuan Organizer</span>
    </a>

        <!-- Kategori -->
        <a href="{{ route('admin.categories.index') }}" 
   class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-xl transition-all duration-200 {{ request()->routeIs('admin.categories.*') ? 'bg-gray-700 text-white' : '' }}">
    <i class="fas fa-tags mr-3 text-lg"></i>
    <span class="font-medium">Kategori</span>
</a>

        <!-- Semua Acara -->
        <a href="{{ route('admin.events.index') }}" 
           class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-xl transition-all duration-200 {{ request()->routeIs('admin.events.*') ? 'bg-gray-700 text-white' : '' }}">
            <i class="fas fa-calendar-alt mr-3 text-lg"></i>
            <span class="font-medium">Semua Acara</span>
        </a>

        <!-- Pemesanan -->
        <a href="{{ route('admin.bookings.index') }}" 
           class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-xl transition-all duration-200 {{ request()->routeIs('admin.bookings.*') ? 'bg-gray-700 text-white' : '' }}">
            <i class="fas fa-ticket-alt mr-3 text-lg"></i>
            <span class="font-medium">Pemesanan</span>
        </a>

        <!-- Laporan -->
        <a href="{{ route('admin.reports.index') }}" 
           class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-xl transition-all duration-200 {{ request()->routeIs('admin.reports.*') ? 'bg-gray-700 text-white' : '' }}">
            <i class="fas fa-chart-bar mr-3 text-lg"></i>
            <span class="font-medium">Laporan</span>
        </a>

        <!-- Analitik -->
        <a href="{{ route('admin.analytics.index') }}" 
           class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-xl transition-all duration-200 {{ request()->routeIs('admin.analytics.*') ? 'bg-gray-700 text-white' : '' }}">
            <i class="fas fa-chart-line mr-3 text-lg"></i>
            <span class="font-medium">Analitik</span>
        </a>
    </nav>

    <!-- Footer Sidebar - DIPERBAIKI SPACING -->
    <div class="p-3 border-t border-gray-700 mt-auto">
        <div class="flex items-center gap-3">
            @if(auth()->user()->profile_image)
                <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" 
                     alt="{{ auth()->user()->name }}" 
                     class="w-8 h-8 rounded-full object-cover">
            @else
                <div class="w-8 h-8 bg-gradient-to-r from-[#1452ce] to-[#2e46fd] rounded-full flex items-center justify-center text-white font-semibold text-sm">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
            @endif
            <div class="flex-1 min-w-0">
                <div class="text-xs text-gray-400">Masuk sebagai</div>
                <div class="font-medium text-white text-sm truncate">{{ auth()->user()->name }}</div>
                <div class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</div>
            </div>
        </div>
    </div>
</div>