{{-- Past Events Section --}}
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Acara yang Telah Berlangsung
            </h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Lihat acara-acara seru yang sudah selesai dan baca review dari peserta
            </p>
        </div>

        @if($pastEvents->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($pastEvents as $event)
                    <x-cards.event-card :event="$event" />
                @endforeach
            </div>
            
            {{-- ⭐⭐⭐ PAGINATION TAMBAHAN ⭐⭐⭐ --}}
            @if($pastEvents->hasPages())
                <div class="mt-8 flex justify-center">
                    {{ $pastEvents->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-12">
                <div class="text-gray-400 text-6xl mb-4">
                    <i class="fas fa-history"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum ada acara yang selesai</h3>
                <p class="text-gray-500">Acara yang sudah berakhir akan muncul di sini</p>
            </div>
        @endif
    </div>
</section>