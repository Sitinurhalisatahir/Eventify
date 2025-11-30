{{-- resources/views/home/partials/featured-events.blade.php --}}
<section class="py-16 bg-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Acara Populer
            </h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Temukan acara-acara spesial yang sedang trending
            </p>
        </div>

        @if($featuredEvents->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($featuredEvents as $event)
                    <x-cards.event-card :event="$event" />
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-8">
                {{ $featuredEvents->links() }}
            </div>
            
            <div class="text-center mt-12">
                <a href="{{ route('events.index') }}" 
                   class="inline-flex items-center bg-[#262363] text-white px-8 py-4 rounded-xl font-bold hover:bg-[#00183c] transition-colors text-lg">
                    <i class="fas fa-calendar-alt mr-3"></i>
                    Lihat Semua Acara
                </a>
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-gray-400 text-6xl mb-4">
                    <i class="fas fa-calendar-times"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum ada acara tersedia</h3>
                <p class="text-gray-500">Silakan coba lagi nanti</p>
            </div>
        @endif
    </div>
</section>