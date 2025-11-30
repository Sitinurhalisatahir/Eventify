{{-- resources/views/events/partials/filter-sidebar.blade.php --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sticky top-4">
    <h3 class="font-semibold text-gray-900 mb-4 text-lg">Filter</h3>
    
    <form method="GET" action="{{ route('events.index') }}" class="space-y-6">
        <!-- Search Input -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Pencarian</label>
            <x-ui.search-bar 
                placeholder="Cari acara..." 
                value="{{ request('search') }}"
            />
        </div>

        <!-- Category Filter -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
            <select name="category" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-[#e6527b] focus:ring-2 focus:ring-[#e6527b] transition-all duration-300 outline-none">
                <option value="">Semua Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }} ({{ $category->events_count }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Location Filter -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
            <input 
                type="text" 
                name="location" 
                value="{{ request('location') }}"
                placeholder="Masukkan lokasi..."
                class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-[#e6527b] focus:ring-2 focus:ring-[#e6527b] transition-all duration-300 outline-none"
            >
        </div>

        <!-- Date Range -->
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Dari</label>
                <input 
                    type="date" 
                    name="date_from" 
                    value="{{ request('date_from') }}"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-[#e6527b] focus:ring-2 focus:ring-[#e6527b] transition-all duration-300 outline-none"
                >
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Sampai</label>
                <input 
                    type="date" 
                    name="date_to" 
                    value="{{ request('date_to') }}"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-[#e6527b] focus:ring-2 focus:ring-[#e6527b] transition-all duration-300 outline-none"
                >
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3 pt-4">
            <button type="submit" class="flex-1 bg-[#262363] text-white py-2 px-4 rounded-lg hover:bg-[#00183c] font-semibold transition-all duration-300">
                Terapkan Filter
            </button>
            <a href="{{ route('events.index') }}" class="bg-gray-200 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-300 font-semibold transition-all duration-300">
                Reset
            </a>
        </div>
    </form>
</div>