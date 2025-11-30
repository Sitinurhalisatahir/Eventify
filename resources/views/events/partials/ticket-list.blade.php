{{-- resources/views/events/partials/ticket-list.blade.php --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
    <h3 class="text-xl font-bold text-gray-900 mb-6">Pilihan Tiket</h3>
    <div class="space-y-4">
        @if($event->tickets->count() > 0)
            @foreach($event->tickets as $ticket)
                <div class="border border-gray-200 rounded-xl p-6 hover:border-[#e6527b] transition-all duration-300 hover:shadow-md">
                    <div class="flex flex-col lg:flex-row lg:items-start gap-6">
                        <!-- Ticket Image -->
                        @if($ticket->image)
                            <img src="{{ asset('storage/' . $ticket->image) }}" 
                                 alt="{{ $ticket->name }}"
                                 class="w-24 h-24 object-cover rounded-lg flex-shrink-0 border border-gray-200">
                        @else
                            <div class="w-24 h-24 bg-[#e692b7]/10 rounded-lg flex items-center justify-center flex-shrink-0 border border-gray-200">
                                <i class="fas fa-ticket-alt text-[#e6527b] text-2xl"></i>
                            </div>
                        @endif

                        <!-- Ticket Info -->
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900 text-lg mb-2">{{ $ticket->name }}</h4>
                                    @if($ticket->description)
                                        <p class="text-gray-600 text-sm mb-4 leading-relaxed">{{ $ticket->description }}</p>
                                    @endif
                                </div>
                                
                                <!-- Price & Availability -->
                                <div class="flex flex-col items-start lg:items-end gap-2">
                                    <span class="text-2xl font-bold text-[#262363]">
                                        Rp {{ number_format($ticket->price, 0, ',', '.') }}
                                    </span>
                                    <span class="text-sm {{ $ticket->isAvailable() ? 'text-green-600' : 'text-red-600' }} font-medium bg-gray-100 px-3 py-1 rounded-full">
                                        <i class="fas fa-ticket-alt mr-1"></i>
                                        {{ $ticket->quota_remaining }} tersisa
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Book Button -->
                    <div class="mt-6 pt-4 border-t border-gray-100">
                        @if($event->isPublished() && $ticket->isAvailable() && $event->isUpcoming())
                            @auth
                                @if(auth()->user()->role === 'user')
                                    <a href="{{ route('user.bookings.create', ['ticket_id' => $ticket->id]) }}" 
                                       class="bg-[#e6527b] text-white px-6 py-3 rounded-lg hover:bg-[#d9416d]font-semibold transition-all duration-300 shadow-md hover:shadow-lg inline-flex items-center">
                                        <i class="fas fa-shopping-cart mr-2"></i>
                                        Pesan Sekarang
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('login') }}" 
                                   class="bg-[#e6527b] text-white px-6 py-3 rounded-lg hover:bg-[#d9416d] font-semibold transition-all duration-300 shadow-md hover:shadow-lg inline-flex items-center">
                                    <i class="fas fa-sign-in-alt mr-2"></i>
                                    Login untuk Memesan
                                </a>
                            @endauth
                        @else
                            <button disabled class="bg-gray-300 text-gray-500 px-6 py-3 rounded-lg font-semibold cursor-not-allowed inline-flex items-center">
                                <i class="fas fa-ban mr-2"></i>
                                {{ $ticket->isSoldOut() ? 'Habis' : 'Tidak Tersedia' }}
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <div class="text-center py-12 bg-gray-50 rounded-xl border border-gray-200">
                <i class="fas fa-ticket-alt text-gray-300 text-5xl mb-4"></i>
                <p class="text-gray-500 text-lg font-medium">Belum ada tiket tersedia untuk acara ini</p>
                <p class="text-gray-400 text-sm mt-2">Silakan coba lagi nanti atau hubungi penyelenggara</p>
            </div>
        @endif
    </div>
</div>