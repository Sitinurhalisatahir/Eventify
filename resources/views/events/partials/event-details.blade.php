{{-- Event Details Partial --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
    <h3 class="text-xl font-bold text-gray-900 mb-6">Event Details</h3>
    <div class="grid md:grid-cols-2 gap-6">
        <div class="flex items-start space-x-3">
            <div class="w-10 h-10 bg-[#00A3FF] bg-opacity-10 rounded-lg flex items-center justify-center flex-shrink-0">
                <i class="fas fa-calendar-day text-[#00A3FF]"></i>
            </div>
            <div>
                <h4 class="font-semibold text-gray-900">Date & Time</h4>
                <p class="text-gray-600">{{ $event->event_date->format('l, F j, Y') }}</p>
                <p class="text-gray-600">{{ $event->event_date->format('g:i A') }}</p>
            </div>
        </div>

        <div class="flex items-start space-x-3">
            <div class="w-10 h-10 bg-[#8A2BE2] bg-opacity-10 rounded-lg flex items-center justify-center flex-shrink-0">
                <i class="fas fa-map-marker-alt text-[#8A2BE2]"></i>
            </div>
            <div>
                <h4 class="font-semibold text-gray-900">Location</h4>
                <p class="text-gray-600">{{ $event->location }}</p>
            </div>
        </div>

        <div class="flex items-start space-x-3">
            <div class="w-10 h-10 bg-green-500 bg-opacity-10 rounded-lg flex items-center justify-center flex-shrink-0">
                <i class="fas fa-tag text-green-500"></i>
            </div>
            <div>
                <h4 class="font-semibold text-gray-900">Category</h4>
                <p class="text-gray-600">{{ $event->category->name ?? 'Uncategorized' }}</p>
            </div>
        </div>

        <div class="flex items-start space-x-3">
            <div class="w-10 h-10 bg-purple-500 bg-opacity-10 rounded-lg flex items-center justify-center flex-shrink-0">
                <i class="fas fa-user text-purple-500"></i>
            </div>
            <div>
                <h4 class="font-semibold text-gray-900">Organizer</h4>
                <p class="text-gray-600">{{ $event->organizer->name }}</p>
            </div>
        </div>
    </div>
</div>