@extends('layouts.admin')

@section('header', 'Manajemen Acara')

@section('content')
<div class="space-y-6">
    <!-- Header dengan Create Button -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Acara</h1>
            <p class="text-gray-600 mt-1">Kelola semua acara dalam sistem</p>
        </div>
        <a href="{{ route('admin.events.create') }}" 
           class="inline-flex items-center px-5 py-2.5 bg-[#f7549a] text-white rounded-lg hover:bg-[#e1498b] transition-all duration-300 font-semibold hover:shadow-lg">
            <i class="fas fa-plus mr-2"></i>
            Buat Acara Baru
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="p-2 rounded-lg bg-blue-100 text-blue-600">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium text-gray-600">Total Acara</p>
                    <p class="text-lg font-bold text-gray-900">{{ $events->total() }}</p>
                </div>
            </div>
        </div>
        
        <!-- Stats lainnya tetap sama -->
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <form method="GET" action="{{ route('admin.events.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Pencarian</label>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Nama acara..."
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#262363] focus:border-[#262363] transition-all duration-300 outline-none text-sm"
                >
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#262363] focus:border-[#262363] transition-all duration-300 outline-none bg-white text-sm">
                    <option value="">Semua Status</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <!-- Category Filter -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori</label>
                <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#262363] focus:border-[#262363] transition-all duration-300 outline-none bg-white text-sm">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Organizer Filter -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Organizer</label>
                <select name="organizer" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#262363] focus:border-[#262363] transition-all duration-300 outline-none bg-white text-sm">
                    <option value="">Semua Organizer</option>
                    @foreach($organizers as $organizer)
                        <option value="{{ $organizer->id }}" {{ request('organizer') == $organizer->id ? 'selected' : '' }}>
                            {{ $organizer->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Buttons -->
            <div class="md:col-span-4 flex justify-end space-x-3 mt-3">
                <a href="{{ route('admin.events.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all duration-300 font-semibold text-sm">
                    <i class="fas fa-refresh mr-2"></i>
                    Reset
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-[#262363] text-white rounded-lg hover:bg-[#00183c] transition-all duration-300 font-semibold text-sm">
                    <i class="fas fa-filter mr-2"></i>
                    Terapkan Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Events Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Semua Acara</h2>
        </div>

        @if($events->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acara
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kategori & Organizer
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal & Lokasi
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tiket
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($events as $event)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <!-- Event Info -->
                                <td class="px-4 py-3">
                                    <div class="flex items-center">
                                        @if($event->image)
                                            <img src="{{ asset('storage/' . $event->image) }}" 
                                                 alt="{{ $event->name }}"
                                                 class="w-10 h-10 rounded-lg object-cover mr-3">
                                        @else
                                            <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center mr-3">
                                                <i class="fas fa-calendar text-gray-400"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900">
                                                {{ $event->name }}
                                            </div>
                                            <div class="text-xs text-gray-500 mt-1 line-clamp-2">
                                                {{ Str::limit($event->description, 60) }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Category & Organizer -->
                                <td class="px-4 py-3">
                                    <div class="space-y-1">
                                        <div class="flex items-center">
                                            @if($event->category->icon)
                                                <div class="w-5 h-5 rounded mr-2 flex items-center justify-center text-white text-xs"
                                                     style="background-color: {{ $event->category->color }}">
                                                    <i class="{{ $event->category->icon }}"></i>
                                                </div>
                                            @endif
                                            <span class="text-sm text-gray-900">{{ $event->category->name }}</span>
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            oleh {{ $event->organizer->name }}
                                        </div>
                                    </div>
                                </td>

                                <!-- Date & Location -->
                                <td class="px-4 py-3">
                                    <div class="space-y-1">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $event->event_date->format('M d, Y H:i') }}
                                        </div>
                                        <div class="text-xs text-gray-500 flex items-center">
                                            <i class="fas fa-map-marker-alt mr-1 text-xs"></i>
                                            {{ Str::limit($event->location, 25) }}
                                        </div>
                                    </div>
                                </td>

                                <!-- Tickets -->
                                <td class="px-4 py-3">
                                    <div class="text-sm text-gray-900">
                                        {{ $event->tickets_count ?? $event->tickets->count() }} tiket
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $event->total_available_tickets }} tersedia
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="px-4 py-3">
                                    @if($event->status === 'published')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Published
                                        </span>
                                    @elseif($event->status === 'draft')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-pause-circle mr-1"></i>
                                            Draft
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-times-circle mr-1"></i>
                                            Cancelled
                                        </span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.events.show', $event) }}" 
                                           class="inline-flex items-center px-2 py-1 bg-[#262363] text-white rounded-lg hover:bg-[#00183c] transition-all duration-300 font-semibold text-xs">
                                            <i class="fas fa-eye mr-1"></i>
                                            Lihat
                                        </a>

                                        <a href="{{ route('admin.events.edit', $event) }}" 
                                           class="inline-flex items-center px-2 py-1 border border-[#262363] text-[#262363] rounded-lg hover:bg-[#262363] hover:text-white transition-all duration-300 font-semibold text-xs">
                                            <i class="fas fa-edit mr-1"></i>
                                            Edit
                                        </a>

                                        <!-- ✅ ADMIN BISA HAPUS SEMUA ACARA -->
                                        <form 
                                            action="{{ route('admin.events.destroy', $event) }}" 
                                            method="POST" 
                                            class="inline"
                                            onsubmit="return confirm('Hapus acara ini? Semua data terkait akan dihapus.')"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center px-2 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all duration-300 font-semibold text-xs">
                                                <i class="fas fa-trash mr-1"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-4 py-3 border-t border-gray-200">
                {{ $events->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-8">
                <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                    <i class="fas fa-calendar-times text-2xl text-gray-400"></i>
                </div>
                <h3 class="text-base font-medium text-gray-900 mb-2">Belum ada acara</h3>
                <p class="text-gray-600 text-sm mb-4">Mulai dengan membuat acara pertama Anda</p>
                <a href="{{ route('admin.events.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-[#e692b7] text-white rounded-lg hover:bg-[#d87ba8] transition-all duration-300 font-semibold text-sm shadow-md hover:shadow-lg">
                    <i class="fas fa-plus mr-2"></i>
                    Buat Acara Pertama
                </a>
            </div>
        @endif
    </div>
</div>
@endsection