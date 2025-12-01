@extends('layouts.admin')

@section('header', $user->name)

@section('content')
<div class="space-y-6">
    <!-- Header Pengguna -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-[#262363] to-[#00183c] px-6 py-4">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-2xl font-bold text-white">{{ $user->name }}</h2>
                    <div class="flex items-center space-x-4 mt-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-white bg-opacity-20 text-white">
                            <i class="fas fa-envelope mr-1"></i> {{ $user->email }}
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold 
                            {{ $user->role === 'admin' ? 'bg-purple-500 text-white' : 
                               ($user->role === 'organizer' ? 'bg-green-500 text-white' : 
                               'bg-blue-500 text-white') }}">
                            {{ $user->role === 'admin' ? 'Admin' : 
                               ($user->role === 'organizer' ? 'Organizer' : 'Pengguna') }}
                        </span>
                        @if($user->role === 'organizer')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold 
                                {{ $user->organizer_status === 'approved' ? 'bg-green-500 text-white' : 
                                   ($user->organizer_status === 'pending' ? 'bg-yellow-500 text-white' : 
                                   'bg-red-500 text-white') }}">
                                {{ $user->organizer_status === 'approved' ? 'Disetujui' : 
                                   ($user->organizer_status === 'pending' ? 'Menunggu' : 'Ditolak') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="flex space-x-3">
                    @if($user->role === 'organizer' && $user->organizer_status === 'pending')
                        <form action="{{ route('admin.organizers.approve', $user) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" 
                                    class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 font-medium transition-colors">
                                <i class="fas fa-check mr-2"></i> Setujui
                            </button>
                        </form>
                        <form action="{{ route('admin.organizers.reject', $user) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" 
                                    class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 font-medium transition-colors">
                                <i class="fas fa-times mr-2"></i> Tolak
                            </button>
                        </form>
                    @endif
                    @if($user->role !== 'admin')
                        <button onclick="confirmDelete()"
                                class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 font-medium transition-colors">
                            <i class="fas fa-trash mr-2"></i> Hapus
                        </button>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Informasi Pengguna -->
                <div class="lg:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pengguna</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Nama</p>
                            <p class="font-medium text-gray-900">{{ $user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="font-medium text-gray-900">{{ $user->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Peran</p>
                            <p class="font-medium text-gray-900">
                                {{ $user->role === 'admin' ? 'Admin' : 
                                   ($user->role === 'organizer' ? 'Organizer' : 'Pengguna') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Bergabung</p>
                            <p class="font-medium text-gray-900">{{ $user->created_at->format('d F Y \\p\\a\\d\\a H:i') }}</p>
                        </div>
                        @if($user->phone)
                            <div>
                                <p class="text-sm text-gray-500">Telepon</p>
                                <p class="font-medium text-gray-900">{{ $user->phone }}</p>
                            </div>
                        @endif
                        @if($user->organizer_description)
                            <div class="md:col-span-2">
                                <p class="text-sm text-gray-500">Deskripsi Organizer</p>
                                <p class="font-medium text-gray-900">{{ $user->organizer_description }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Statistik -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800">Statistik</h3>
                    @if($user->role === 'organizer')
                        <div class="space-y-3">
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="text-gray-600">Total Acara</span>
                                <span class="font-bold text-gray-800">{{ $statistics['total_events'] ?? 0 }}</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="text-gray-600">Acara Terbit</span>
                                <span class="font-bold text-green-600">{{ $statistics['published_events'] ?? 0 }}</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="text-gray-600">Total Pemesanan</span>
                                <span class="font-bold text-blue-600">{{ $statistics['total_bookings'] ?? 0 }}</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="text-gray-600">Total Pendapatan</span>
                                <span class="font-bold text-purple-600">Rp {{ number_format($statistics['total_revenue'] ?? 0, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    @elseif($user->role === 'user')
                        <div class="space-y-3">
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="text-gray-600">Total Pemesanan</span>
                                <span class="font-bold text-gray-800">{{ $statistics['total_bookings'] ?? 0 }}</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="text-gray-600">Pemesanan Disetujui</span>
                                <span class="font-bold text-green-600">{{ $statistics['approved_bookings'] ?? 0 }}</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="text-gray-600">Total Pengeluaran</span>
                                <span class="font-bold text-blue-600">Rp {{ number_format($statistics['total_spent'] ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="text-gray-600">Favorit</span>
                                <span class="font-bold text-purple-600">{{ $statistics['total_favorites'] ?? 0 }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Aktivitas Terbaru -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @if($user->role === 'organizer')
            <!-- Acara Terbaru -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Acara Terbaru</h3>
                @if($user->events->count() > 0)
                    <div class="space-y-3">
                        @foreach($user->events as $event)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-800">{{ $event->name }}</h4>
                                    <div class="flex items-center space-x-2 mt-1 text-sm text-gray-600">
                                        <span>{{ $event->event_date->format('d M Y') }}</span>
                                        <span>•</span>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                            {{ $event->status === 'published' ? 'bg-green-100 text-green-800' : 
                                               ($event->status === 'draft' ? 'bg-yellow-100 text-yellow-800' : 
                                               'bg-red-100 text-red-800') }}">
                                            {{ $event->status === 'published' ? 'Terbit' : 
                                               ($event->status === 'draft' ? 'Draft' : $event->status) }}
                                        </span>
                                    </div>
                                </div>
                                <a href="{{ route('admin.events.show', $event) }}" 
                                   class="bg-[#262363] text-white px-3 py-1 rounded-lg hover:bg-[#00183c] text-sm font-medium transition-colors">
                                    Lihat
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">Belum ada acara yang dibuat</p>
                @endif
            </div>

        @elseif($user->role === 'user')
            <!-- Pemesanan Terbaru -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Pemesanan Terbaru</h3>
                @if($user->bookings->count() > 0)
                    <div class="space-y-3">
                        @foreach($user->bookings as $booking)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-800">{{ $booking->ticket->event->name }}</h4>
                                    <div class="flex items-center space-x-2 mt-1 text-sm text-gray-600">
                                        <span>{{ $booking->booking_code }}</span>
                                        <span>•</span>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                            {{ $booking->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                               ($booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                               'bg-red-100 text-red-800') }}">
                                            {{ $booking->status === 'approved' ? 'Disetujui' : 
                                               ($booking->status === 'pending' ? 'Menunggu' : 
                                               ($booking->status === 'cancelled' ? 'Dibatalkan' : 'Ditolak')) }}
                                        </span>
                                    </div>
                                </div>
                                <a href="{{ route('admin.bookings.show', $booking) }}" 
                                   class="bg-[#262363] text-white px-3 py-1 rounded-lg hover:bg-[#00183c] text-sm font-medium transition-colors">
                                    Lihat
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">Belum ada pemesanan</p>
                @endif
            </div>

            <!-- Favorit Terbaru -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Favorit Terbaru</h3>
                @if($user->favorites->count() > 0)
                    <div class="space-y-3">
                        @foreach($user->favorites as $favorite)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-800">{{ $favorite->event->name }}</h4>
                                    <p class="text-sm text-gray-600 mt-1">{{ $favorite->event->event_date->format('d M Y') }}</p>
                                </div>
                                <a href="{{ route('admin.events.show', $favorite->event) }}" 
                                   class="bg-[#262363] text-white px-3 py-1 rounded-lg hover:bg-[#00183c] text-sm font-medium transition-colors">
                                    Lihat
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">Belum ada favorit</p>
                @endif
            </div>
        @endif
    </div>
</div>

<!-- Form Konfirmasi Hapus -->
<form id="delete-form" action="{{ route('admin.users.destroy', $user) }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

<script>
function confirmDelete() {
    if (confirm('Apakah Anda yakin ingin menghapus pengguna ini? Tindakan ini tidak dapat dibatalkan.')) {
        document.getElementById('delete-form').submit();
    }
}
</script>
@endsection