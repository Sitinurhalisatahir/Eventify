{{-- resources/views/user/bookings/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Booking ' . $booking->booking_code . ' - ' . config('app.name', 'Eventify'))

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Detail Pemesanan</h1>
                    <p class="text-gray-600">Kode booking: {{ $booking->booking_code }}</p>
                </div>
                <div class="text-right">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                        {{ $booking->status === 'approved' ? 'bg-green-100 text-green-800' : 
                           ($booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                           'bg-red-100 text-red-800') }}">
                        {{ $booking->status === 'approved' ? 'Disetujui' : ($booking->status === 'pending' ? 'Menunggu' : 'Dibatalkan') }}
                    </span>
                    <p class="text-sm text-gray-500 mt-1">
                        {{ $booking->created_at->timezone('Asia/Makassar')->format('d/m/Y H:i') }} WITA
                    </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Booking Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Digital Ticket -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-[#262363] to-[#52154E] p-6 text-white">
                        <div class="flex justify-between items-start">
                            <div>
                                <h2 class="text-2xl font-bold mb-2">E-Ticket</h2>
                                <p class="text-gray-200">{{ $booking->ticket->event->name }}</p>
                            </div>
                            <div class="text-right">
                                <div class="text-3xl font-bold">{{ $booking->booking_code }}</div>
                                <p class="text-gray-200 text-sm">Kode Booking</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 gap-6 mb-6">
                            <div>
                                <p class="text-sm text-gray-600">Acara</p>
                                <p class="font-semibold text-gray-900">{{ $booking->ticket->event->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Jenis Tiket</p>
                                <p class="font-semibold text-gray-900">{{ $booking->ticket->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Tanggal & Waktu</p>
                                <p class="font-semibold text-gray-900">{{ $booking->ticket->event->event_date->format('d M Y | H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Lokasi</p>
                                <p class="font-semibold text-gray-900">{{ $booking->ticket->event->location }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Jumlah</p>
                                <p class="font-semibold text-gray-900">{{ $booking->quantity }} tiket</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Total Pembayaran</p>
                                <p class="font-semibold text-gray-900">IDR {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        
                        @if($booking->isApproved())
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <div class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                                    <div>
                                        <p class="font-semibold text-green-800">Pemesanan Disetujui</p>
                                        <p class="text-green-700 text-sm">Tiket Anda sudah dikonfirmasi. Silakan tunjukkan e-ticket ini di pintu masuk acara.</p>
                                    </div>
                                </div>
                            </div>
                        @elseif($booking->isPending())
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <div class="flex items-center">
                                    <i class="fas fa-clock text-yellow-500 text-xl mr-3"></i>
                                    <div>
                                        <p class="font-semibold text-yellow-800">Menunggu Persetujuan</p>
                                        <p class="text-yellow-700 text-sm">Pemesanan Anda menunggu persetujuan dari penyelenggara acara.</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Event Details -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Informasi Acara</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex items-start space-x-3">
                            <div class="w-10 h-10 bg-[#e692b7]/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-calendar-day text-[#e6527b]"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Tanggal & Waktu</h4>
                                <p class="text-gray-600">{{ $booking->ticket->event->event_date->translatedFormat('l, j F Y') }}</p>
                                <p class="text-gray-600">{{ $booking->ticket->event->event_date->format('H:i') }}</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3">
                            <div class="w-10 h-10 bg-[#e692b7]/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-map-marker-alt text-[#e6527b]"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Lokasi</h4>
                                <p class="text-gray-600">{{ $booking->ticket->event->location }}</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3">
                            <div class="w-10 h-10 bg-[#e692b7]/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-user text-[#e6527b]"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Penyelenggara</h4>
                                <p class="text-gray-600">{{ $booking->ticket->event->organizer->name }}</p>
                            </div>
                        </div>

                        @if($booking->ticket->event->category)
                            <div class="flex items-start space-x-3">
                                <div class="w-10 h-10 bg-[#e692b7]/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="{{ $booking->ticket->event->category->icon }} text-[#e6527b]"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">Kategori</h4>
                                    <p class="text-gray-600">{{ $booking->ticket->event->category->name }}</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    @if($booking->ticket->event->description)
                        <div class="mt-6">
                            <h4 class="font-semibold text-gray-900 mb-2">Tentang Acara Ini</h4>
                            <p class="text-gray-600">{{ $booking->ticket->event->description }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Booking Actions -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Aksi Pemesanan</h3>
                    
                    <div class="space-y-3">
                        <a href="{{ route('events.show', $booking->ticket->event) }}" 
                           class="w-full bg-[#262363] text-white py-3 px-4 rounded-lg hover:bg-[#00183c] font-medium transition-colors text-center block">
                            <i class="fas fa-eye mr-2"></i> Lihat Acara
                        </a>

                        @if($canCancel)
                            <form action="{{ route('user.bookings.destroy', $booking) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full bg-red-600 text-white py-3 px-4 rounded-lg hover:bg-red-700 font-medium transition-colors text-center block"
                                        onclick="return confirm('Yakin ingin membatalkan pemesanan ini?')">
                                    <i class="fas fa-times mr-2"></i> Batalkan Pemesanan
                                </button>
                            </form>
                        @endif

                        @if($canReview)
                        <a href="{{ route('user.reviews.create', ['event' => $booking->ticket->event, 'booking' => $booking]) }}" 
                            class="w-full bg-green-600 text-white py-3 px-4 rounded-lg hover:bg-green-700 font-medium transition-colors text-center block no-print">
                            <i class="fas fa-star mr-2"></i> Beri Ulasan
                        </a>
                        @endif

                        <button onclick="window.print()" 
                                class="w-full bg-gray-200 text-gray-700 py-3 px-4 rounded-lg hover:bg-gray-300 font-medium transition-colors text-center block">
                            <i class="fas fa-print mr-2"></i> Cetak Tiket
                        </button>
                    </div>
                </div>

                <!-- Organizer Contact -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Penyelenggara Acara</h3>
                    <div class="flex items-center space-x-3 mb-4">
                        @if($booking->ticket->event->organizer->photo)
                            <img src="{{ asset('storage/' . $booking->ticket->event->organizer->photo) }}" 
                                 alt="{{ $booking->ticket->event->organizer->name }}"
                                 class="w-12 h-12 rounded-full object-cover">
                        @else
                            <div class="w-12 h-12 bg-gradient-to-r from-[#262363] to-[#52154E] rounded-full flex items-center justify-center text-white font-semibold">
                                {{ substr($booking->ticket->event->organizer->name, 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <h4 class="font-semibold text-gray-900">{{ $booking->ticket->event->organizer->name }}</h4>
                            <p class="text-sm text-gray-500">Penyelenggara Acara</p>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600">Hubungi penyelenggara untuk pertanyaan tentang acara ini atau pemesanan Anda.</p>
                </div>

                <!-- Need Help -->
                <div class="bg-[#e692b7]/10 rounded-2xl border border-[#e692b7]/20 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Butuh Bantuan?</h3>
                    <p class="text-sm text-gray-600 mb-4">Mengalami masalah dengan pemesanan Anda?</p>
                    <a href="#" class="text-[#262363] hover:text-[#00183c] font-medium text-sm inline-flex items-center">
                        <i class="fas fa-question-circle mr-2"></i> Hubungi Dukungan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .no-print {
        display: none !important;
    }
    
    body {
        background: white !important;
    }
    
    .bg-gray-50 {
        background: white !important;
    }
}
</style>
@endsection