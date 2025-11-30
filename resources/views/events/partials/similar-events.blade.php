{{-- Similar Events Partial --}}
@if($similarEvents->count() > 0)
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Similar Events</h3>
        <div class="space-y-4">
            @foreach($similarEvents as $similarEvent)
                <a href="{{ route('events.show', $similarEvent) }}" class="flex items-center space-x-3 group">
                    @if($similarEvent->image)
                        <img src="{{ asset('storage/' . $organizer->photo) }}" alt="{{ $organizer->name }}" class="w-16 h-16 rounded-lg object-cover">
                    @else
                        <div class="w-16 h-16 bg-gradient-to-br from-[#00A3FF] to-[#8A2BE2] rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-white text-sm"></i>
                        </div>
                    @endif
                    <div class="flex-1">
                        <h4 class="font-semibold text-gray-900 group-hover:text-[#00A3FF] transition-colors text-sm line-clamp-2">{{ $similarEvent->name }}</h4>
                        <p class="text-gray-500 text-xs">{{ $similarEvent->event_date->format('M j, Y') }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endif