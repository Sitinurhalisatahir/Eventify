{{-- Upcoming Events Section --}}
<section class="py-16 bg-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header Section --}}
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Acara Mendatang
            </h2>
            <p class="text-lg text-gray-600">
                Jangan lewatkan acara-acara seru yang akan datang
            </p>
        </div>

        @if($upcomingEvents->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($upcomingEvents as $event)
                    <x-cards.event-card :event="$event" />
                @endforeach
            </div>
            
            {{-- ⭐⭐⭐ PAGINATION TAMBAHAN ⭐⭐⭐ --}}
            @if($upcomingEvents->hasPages())
                <div class="mt-8 flex justify-center">
                    {{ $upcomingEvents->links() }}
                </div>
            @endif
            
            {{-- CTA Button --}}
            <div class="text-center mt-11">
                <a href="{{ route('events.index') }}" 
                   class="inline-flex items-center bg-[#262363] text-white px-8 py-4 rounded-xl font-bold hover:bg-[#00183c] transition-colors text-lg">
                    <i class="fas fa-list mr-3"></i>
                    Lihat Semua
                </a>
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-gray-400 text-6xl mb-4">
                    <i class="fas fa-calendar-plus"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">Tidak ada acara mendatang</h3>
                <p class="text-gray-500">Acara baru akan segera hadir</p>
            </div>
        @endif
    </div>
</section>