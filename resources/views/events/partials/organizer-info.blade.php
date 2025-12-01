{{-- Organizer Info Partial --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
    <h3 class="text-lg font-bold text-gray-900 mb-4">Penyelenggara</h3>
    <div class="flex items-center space-x-3 mb-4">
        @if($event->organizer->photo)
            <img src="{{ assets('stroge/'. $event->organizer->photo) }}" alt="{{ $event->organizer->name }}" class="w-12 h-12 rounded-full object-cover">
        @else
            <div class="w-12 h-12 bg-gradient-to-r from-[#00A3FF] to-[#8A2BE2] rounded-full flex items-center justify-center text-white font-semibold">
                {{ substr($event->organizer->name, 0, 1) }}
            </div>
        @endif
        <div>
            <h4 class="font-semibold text-gray-900">{{ $event->organizer->name }}</h4>
            <p class="text-sm text-gray-500">Acara Organizer</p>
        </div>
    </div>
    <p class="text-gray-600 text-sm">Hubungi penyelenggara untuk pertanyaan apa pun tentang acara ini</p>
</div>