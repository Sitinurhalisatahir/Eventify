<div>
    <form method="GET" action="{{ url()->current() }}">
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