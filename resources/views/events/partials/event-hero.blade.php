{{-- Event Hero Partial --}}
<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-sm">
                <li>
                    <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700">Beranda</a>
                </li>
                <li>
                    <span class="text-gray-400">/</span>
                </li>
                <li>
                    <a href="{{ route('events.index') }}" class="text-gray-500 hover:text-gray-700">Acara</a>
                </li>
                <li>
                    <span class="text-gray-400">/</span>
                </li>
                <li>
                    <span class="text-gray-900 font-medium truncate">{{ Str::limit($event->name, 30) }}</span>
                </li>
            </ol>
        </nav>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Event Image & Basic Info -->
            <div class="lg:col-span-2">
                @if($event->image)
                    <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}" class="w-full h-96 object-cover rounded-2xl shadow-lg">
                @else
                    <div class="w-full h-96 bg-gray-200 rounded-2xl shadow-lg flex items-center justify-center">
                        <i class="fas fa-calendar-alt text-gray-400 text-6xl"></i>
                    </div>
                @endif

                <!-- Event Status & Actions -->
                <div class="flex justify-between items-center mt-6">
                    <div class="flex items-center gap-4">
                        @if($event->isCancelled())
                            <span class="bg-red-500 text-white px-4 py-2 rounded-full text-sm font-semibold">
                                DIBATALKAN
                            </span>
                        @elseif($event->isPast())
                            <span class="bg-gray-500 text-white px-4 py-2 rounded-full text-sm font-semibold">
                                SELESAI
                            </span>
                        @elseif($event->isUpcoming())
                            <span class="bg-green-500 text-white px-4 py-2 rounded-full text-sm font-semibold">
                                AKAN DATANG
                            </span>
                        @endif

                        @if($event->category)
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-gray-100 text-gray-800 border border-gray-200">
                                <i class="{{ $event->category->icon }} mr-2"></i>
                                {{ $event->category->name }}
                            </span>
                        @endif
                    </div>

                    <!-- Favorite Button -->
                    @auth
                        @if(auth()->user()->role === 'user')
                            <form action="{{ $isFavorited ? route('user.favorites.destroy', $event) : route('user.favorites.store', $event) }}" method="POST">
                                @csrf
                                @if($isFavorited)
                                    @method('DELETE')
                                @endif
                                <button type="submit" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 font-semibold transition-all duration-300">
                                    <i class="{{ $isFavorited ? 'fas text-red-500' : 'far' }} fa-heart mr-2"></i>
                                    {{ $isFavorited ? 'Hapus Favorit' : 'Tambah Favorit' }}
                                </button>
                            </form>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Booking Section -->
            <div class="lg:col-span-1">
                @include('events.partials.booking-sidebar')
            </div>
        </div>
    </div>
</div>