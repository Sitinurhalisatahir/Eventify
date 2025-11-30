{{-- resources/views/user/bookings/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Book Ticket - ' . config('app.name', 'Eventify'))

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Pesan Tiket Anda</h1>
            <p class="text-gray-600">Lengkapi pemesanan untuk acara ini</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Booking Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Detail Pemesanan</h2>

                    <!-- Ticket Information -->
                    <div class="bg-[#e692b7]/10 rounded-lg p-4 mb-6">
                        <h3 class="font-semibold text-gray-900 text-lg mb-2">{{ $ticket->event->name }}</h3>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-600">Jenis Tiket:</span>
                                <span class="font-medium text-gray-900">{{ $ticket->name }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Harga:</span>
                                <span class="font-medium text-[#262363]">Published {{ number_format($ticket->price, 0, ',', '.') }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Tersedia:</span>
                                <span class="font-medium {{ $ticket->quota_remaining > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $ticket->quota_remaining }} tiket
                                </span>
                            </div>
                            <div>
                                <span class="text-gray-600">Tanggal Acara:</span>
                                <span class="font-medium text-gray-900">{{ $ticket->event->event_date->format('M j, Y | g:i A') }}</span>
                            </div>
                        </div>
                    </div>

                    @if($ticket->description)
                        <div class="mb-6">
                            <h4 class="font-medium text-gray-900 mb-2">Deskripsi Tiket</h4>
                            <p class="text-gray-600 text-sm">{{ $ticket->description }}</p>
                        </div>
                    @endif

                    <!-- Booking Form -->
                    <form action="{{ route('user.bookings.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

                        <!-- Quantity Selection -->
                        <div class="mb-6">
                            <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">
                                Jumlah Tiket
                            </label>
                            <select name="quantity" id="quantity" 
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-[#e6527b] focus:ring-2 focus:ring-[#e6527b] transition-all duration-300 outline-none"
                                    required>
                                @for($i = 1; $i <= min(10, $ticket->quota_remaining); $i++)
                                    <option value="{{ $i }}">{{ $i }} tiket</option>
                                @endfor
                            </select>
                            @if($ticket->quota_remaining <= 0)
                                <p class="text-red-600 text-sm mt-2">Tiket ini sudah habis</p>
                            @else
                                <p class="text-gray-500 text-sm mt-2">Maksimal {{ min(10, $ticket->quota_remaining) }} tiket per pemesanan</p>
                            @endif
                        </div>

                        <!-- Price Calculation -->
                        <div class="bg-[#e692b7]/10 rounded-lg p-4 mb-6">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-600">Harga per tiket:</span>
                                <span class="font-medium text-gray-900">Published {{ number_format($ticket->price, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-600">Jumlah:</span>
                                <span id="quantity-display" class="font-medium text-gray-900">1</span>
                            </div>
                            <hr class="my-2 border-[#e692b7]/30">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-semibold text-gray-900">Total Pembayaran:</span>
                                <span id="total-price" class="text-lg font-bold text-[#262363]">
                                    Published {{ number_format($ticket->price, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="mb-6">
                            <div class="flex items-start">
                                <input type="checkbox" name="terms" id="terms" 
                                       class="mt-1 rounded border-gray-300 text-[#e6527b] focus:ring-[#e6527b]" required>
                                <label for="terms" class="ml-2 text-sm text-gray-600">
                                    Saya setuju dengan <a href="#" class="text-[#262363] hover:text-[#00183c]">syarat dan ketentuan</a> 
                                    dan memahami bahwa pemesanan ini tunduk pada persetujuan penyelenggara acara.
                                </label>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-4">
                            <button type="submit" 
                            class="flex-1 bg-[#e6527b] text-white py-3 px-6 rounded-lg hover:bg-[#d9416d] font-semibold text-lg transition-all duration-300 shadow-lg hover:shadow-xl {{ $ticket->quota_remaining <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                            {{ $ticket->quota_remaining <= 0 ? 'disabled' : '' }}>
                                <i class="fas fa-credit-card mr-2"></i>
                                Konfirmasi Pemesanan
                            </button>
                            <a href="{{ route('events.show', $ticket->event) }}" 
                               class="bg-gray-200 text-gray-700 py-3 px-6 rounded-lg hover:bg-gray-300 font-semibold text-lg transition-colors">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Event Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sticky top-4">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Ringkasan Acara</h3>
                    
                    @if($ticket->event->image)
                        <img src="{{ asset('storage/' . $ticket->event->image) }}"
                             alt="{{ $ticket->event->name }}"
                             class="w-full h-40 object-cover rounded-lg mb-4">
                    @else
                        <div class="<div class="w-full h-40 bg-gradient-to-br from-[#262363] to-[#00183c] rounded-lg flex items-center justify-center mb-4">>
                            <i class="fas fa-calendar-alt text-white text-2xl"></i>
                        </div>
                    @endif

                    <div class="space-y-3">
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-calendar-day w-5 mr-3"></i>
                            <span class="text-sm">{{ $ticket->event->event_date->format('M j, Y | g:i A') }}</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-map-marker-alt w-5 mr-3"></i>
                            <span class="text-sm">{{ $ticket->event->location }}</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-user w-5 mr-3"></i>
                            <span class="text-sm">{{ $ticket->event->organizer->name }}</span>
                        </div>
                        @if($ticket->event->category)
                            <div class="flex items-center text-gray-600">
                                <i class="{{ $ticket->event->category->icon }} w-5 mr-3"></i>
                                <span class="text-sm">{{ $ticket->event->category->name }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const quantitySelect = document.getElementById('quantity');
        const quantityDisplay = document.getElementById('quantity-display');
        const totalPrice = document.getElementById('total-price');
        const ticketPrice = {{ $ticket->price }};

        function updatePrice() {
            const quantity = parseInt(quantitySelect.value);
            const total = ticketPrice * quantity;
            
            quantityDisplay.textContent = quantity + ' tiket';
            totalPrice.textContent = 'Published ' + total.toLocaleString('id-ID');
        }

        quantitySelect.addEventListener('change', updatePrice);
        
        // Initial calculation
        updatePrice();
    });
</script>
@endpush
@endsection