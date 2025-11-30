{{-- resources/views/components/ui/search-bar.blade.php --}}
@props([
    'placeholder' => 'Cari acara...',
    'value' => '',
])

<div class="relative rounded-xl shadow-sm">
    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
        <i class="fas fa-search text-gray-400"></i>
    </div>
   <input 
    type="text" 
    name="search" 
    value="{{ $value }}"
    class="block w-full rounded-xl border border-gray-300 py-3 pl-10 pr-24 focus:border-[#e6527b] focus:ring-2 focus:ring-[#e6527b] transition-all duration-300 outline-none text-gray-900 bg-white"
    placeholder="{{ $placeholder }}"
    {{ $attributes }}
    >
    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
        <button type="submit" class="bg-[#262363] text-white px-4 py-2 rounded-lg hover:bg-[#00183c] transition-all duration-300 font-semibold text-sm">
            Cari
        </button>
    </div>
</div>