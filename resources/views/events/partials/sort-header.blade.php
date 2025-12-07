<div class="flex items-center justify-between mb-6">
    <form method="GET" action="{{ route('events.index') }}" class="flex items-center gap-3">
        {{-- Preserve other filters --}}
        @if(request('category'))
            <input type="hidden" name="category" value="{{ request('category') }}">
        @endif
        @if(request('location'))
            <input type="hidden" name="location" value="{{ request('location') }}">
        @endif
        @if(request('search'))
            <input type="hidden" name="search" value="{{ request('search') }}">
        @endif
        @if(request('filter'))
            <input type="hidden" name="filter" value="{{ request('filter') }}">
        @endif
        @if(request('date_from'))
            <input type="hidden" name="date_from" value="{{ request('date_from') }}">
        @endif
        @if(request('date_to'))
            <input type="hidden" name="date_to" value="{{ request('date_to') }}">
        @endif
        
        <label class="text-sm font-medium text-gray-700 whitespace-nowrap">Urutkan:</label>
        <select name="sort_by" 
                onchange="this.form.submit()" 
                class="rounded-lg border border-gray-300 px-3 py-2 focus:border-[#e6527b] focus:ring-2 focus:ring-[#e6527b] transition-all duration-300 outline-none text-sm">
            <option value="date" {{ request('sort_by', 'date') == 'date' ? 'selected' : '' }}>Tanggal Terdekat</option>
            <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Nama A-Z</option>
            <option value="price_low" {{ request('sort_by') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
            <option value="price_high" {{ request('sort_by') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
        </select>
    </form>
</div>