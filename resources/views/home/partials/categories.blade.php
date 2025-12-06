{{-- Categories Section --}}
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Jelajahi Kategori
            </h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Temukan acara berdasarkan kategori favorit Anda
            </p>
        </div>

        @if($categories->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($categories as $category)
                    <a href="{{ route('events.index', ['category' => $category->id]) }}" 
                       class="group bg-white border-2 border-gray-200 rounded-2xl p-6 text-center hover:border-[#00A3FF] hover:shadow-lg transition-all duration-300">
                        @if($category->icon)
                            <div class="w-12 h-12 mx-auto mb-3 rounded-xl flex items-center justify-center text-white text-xl"
                                 style="background-color: {{ $category->color ?? '#00A3FF' }}">
                                <i class="{{ $category->icon }}"></i>
                            </div>
                        @else
                            <div class="w-12 h-12 mx-auto mb-3 bg-gradient-to-r from-[#00A3FF] to-[#8A2BE2] rounded-xl flex items-center justify-center text-white text-xl">
                                <i class="fas fa-tag"></i>
                            </div>
                        @endif
                        <h3 class="font-semibold text-gray-900 group-hover:text-[#00A3FF] transition-colors">
                            {{ $category->name }}
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            {{ $category->events_count }} acara
                        </p>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <p class="text-gray-500">Belum ada kategori tersedia</p>
            </div>
        @endif
    </div>
</section>