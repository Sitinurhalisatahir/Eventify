{{-- Event Details Partial --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
    <h3 class="text-xl font-bold text-gray-900 mb-6">Detail Acara</h3>
    <div class="grid md:grid-cols-2 gap-6">
        <div class="flex items-start space-x-3">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <i class="fas fa-calendar-day text-[#2563EB]"></i>
            </div>
            <div>
                <h4 class="font-semibold text-gray-900">Tanggal & Waktu</h4>
                <p class="text-gray-600">{{ $event->event_date->translatedFormat('l, j F Y') }}</p>
                <p class="text-gray-600">{{ $event->event_date->format('H:i') }} WIB</p>
            </div>
        </div>

        <div class="flex items-start space-x-3">
            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <i class="fas fa-map-marker-alt text-[#7C3AED]"></i>
            </div>
            <div>
                <h4 class="font-semibold text-gray-900">Lokasi</h4>
                <p class="text-gray-600">{{ $event->location }}</p>
            </div>
        </div>

        <div class="flex items-start space-x-3">
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <i class="fas fa-tag text-green-600"></i>
            </div>
            <div>
                <h4 class="font-semibold text-gray-900">Kategori</h4>
                <p class="text-gray-600">{{ $event->category->name ?? 'Tidak Berkategori' }}</p>
            </div>
        </div>

        <div class="flex items-start space-x-3">
            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <i class="fas fa-user text-orange-600"></i>
            </div>
            <div>
                <h4 class="font-semibold text-gray-900">Penyelenggara</h4>
                <p class="text-gray-600">{{ $event->organizer->name }}</p>
            </div>
        </div>
    </div>
</div>