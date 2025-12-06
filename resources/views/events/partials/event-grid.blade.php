{{-- resources/views/events/partials/event-grid.blade.php --}}
@if($events->count() > 0)
    <!-- Results Count -->
    <div class="mb-6 text-gray-600">
        Menampilkan {{ $events->firstItem() }} - {{ $events->lastItem() }} dari {{ $events->total() }} acara
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($events as $event)
            <x-cards.event-card :event="$event" />
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $events->links() }}
    </div>
@else
    <!-- Empty State -->
    <div class="text-center py-12 bg-white rounded-2xl shadow-sm border border-gray-200">
        <div class="text-gray-400 text-6xl mb-4">
            <i class="fas fa-calendar-times"></i>
        </div>
        <h3 class="text-xl font-semibold text-gray-600 mb-2">Tidak ada acara ditemukan</h3>
        <p class="text-gray-500 mb-6">Coba sesuaikan filter pencarian Anda</p>
        <a href="{{ route('events.index') }}" class="bg-[#262363] text-white px-6 py-3 rounded-lg hover:bg-[#00183c] font-semibold transition-all duration-300">
            Hapus Filter
        </a>
    </div>
@endif