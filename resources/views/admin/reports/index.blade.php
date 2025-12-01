@extends('layouts.admin')

@section('header', 'Laporan Penjualan & Analitik')

@section('content')
<div class="space-y-6">
    <!-- Filter Tanggal -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Filter Laporan</h3>
        <form method="GET" class="flex flex-col gap-4">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                    <input type="date" name="start_date" value="{{ $startDate }}" 
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Akhir</label>
                    <input type="date" name="end_date" value="{{ $endDate }}" 
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            
            <!-- Container untuk tombol yang sejajar -->
            <div class="flex flex-col sm:flex-row gap-3 sm:items-center">
                <button type="submit" 
                        class="bg-[#262363] text-white px-6 py-2 rounded-lg hover:bg-[#262363] font-medium transition-colors flex items-center justify-center order-2 sm:order-1">
                    <i class="fas fa-filter mr-2"></i>Terapkan Filter
                </button>
                <a href="{{ route('admin.reports.index') }}" 
                   class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 font-medium transition-colors flex items-center justify-center order-1 sm:order-2">
                    <i class="fas fa-refresh mr-2"></i>Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Statistik Ringkasan -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <x-cards.stats-card 
            title="Total Pendapatan" 
            value="Rp {{ number_format($totalRevenue, 0, ',', '.') }}"
            icon="fas fa-money-bill-wave"
            color="green" />

        <x-cards.stats-card 
            title="Total Pemesanan" 
            value="{{ number_format($totalBookings, 0, ',', '.') }}"
            icon="fas fa-shopping-cart"
            color="blue" />

        <x-cards.stats-card 
            title="Tiket Terjual" 
            value="{{ number_format($statistics['total_tickets_sold'], 0, ',', '.') }}"
            icon="fas fa-ticket-alt"
            color="purple" />

        <x-cards.stats-card 
            title="Acara Aktif" 
            value="{{ number_format($statistics['total_events'], 0, ',', '.') }}"
            icon="fas fa-calendar-check"
            color="orange" />
    </div>

    <!-- Ringkasan Pendapatan & Pemesanan -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Pendapatan berdasarkan Status -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Pendapatan berdasarkan Status</h3>
            <div class="space-y-3">
                @foreach(['approved' => 'Disetujui', 'pending' => 'Tertunda', 'cancelled' => 'Dibatalkan', 'rejected' => 'Ditolak'] as $status => $label)
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">{{ $label }}</span>
                    <span class="font-semibold text-gray-800">
                        Rp {{ number_format($revenueByStatus[$status] ?? 0, 0, ',', '.') }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Pemesanan berdasarkan Status -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Pemesanan berdasarkan Status</h3>
            <div class="space-y-3">
                @foreach(['approved' => 'Disetujui', 'pending' => 'Tertunda', 'cancelled' => 'Dibatalkan', 'rejected' => 'Ditolak'] as $status => $label)
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">{{ $label }}</span>
                    <span class="font-semibold text-gray-800">
                        {{ number_format($bookingsByStatus[$status] ?? 0, 0, ',', '.') }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Bagian Acara Teratas -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Acara Teratas berdasarkan Pendapatan -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Acara Teratas berdasarkan Pendapatan</h3>
            <div class="space-y-3">
                @forelse($topEventsByRevenue as $event)
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <div class="flex-1">
                        <h4 class="font-medium text-gray-800">{{ $event->name }}</h4>
                        <p class="text-sm text-gray-500">{{ $event->organizer->name }}</p>
                    </div>
                    <span class="font-semibold text-green-600">
                        Rp {{ number_format($event->revenue, 0, ',', '.') }}
                    </span>
                </div>
                @empty
                <p class="text-gray-500 text-center py-4">Tidak ada data pendapatan tersedia</p>
                @endforelse
            </div>
        </div>

        <!-- Acara Teratas berdasarkan Pemesanan -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Acara Teratas berdasarkan Pemesanan</h3>
            <div class="space-y-3">
                @forelse($topEventsByBookings as $event)
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <div class="flex-1">
                        <h4 class="font-medium text-gray-800">{{ $event->name }}</h4>
                        <p class="text-sm text-gray-500">{{ $event->organizer->name }}</p>
                    </div>
                    <span class="font-semibold text-blue-600">
                        {{ $event->bookings_count }} pemesanan
                    </span>
                </div>
                @empty
                <p class="text-gray-500 text-center py-4">Tidak ada data pemesanan tersedia</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Kinerja Kategori & Penyelenggara -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Pendapatan berdasarkan Kategori -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Pendapatan berdasarkan Kategori</h3>
            <div class="space-y-3">
                @forelse($revenueByCategory as $category)
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <i class="{{ $category->icon }} text-gray-500 mr-3"></i>
                        <span class="font-medium text-gray-800">{{ $category->name }}</span>
                    </div>
                    <span class="font-semibold text-purple-600">
                        Rp {{ number_format($category->revenue, 0, ',', '.') }}
                    </span>
                </div>
                @empty
                <p class="text-gray-500 text-center py-4">Tidak ada data pendapatan kategori</p>
                @endforelse
            </div>
        </div>

        <!-- Penyelenggara Teratas -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Penyelenggara Teratas berdasarkan Pendapatan</h3>
            <div class="space-y-3">
                @forelse($topOrganizersByRevenue as $organizer)
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <div class="flex-1">
                        <h4 class="font-medium text-gray-800">{{ $organizer->name }}</h4>
                        <p class="text-sm text-gray-500">{{ $organizer->email }}</p>
                    </div>
                    <span class="font-semibold text-orange-600">
                        Rp {{ number_format($organizer->revenue, 0, ',', '.') }}
                    </span>
                </div>
                @empty
                <p class="text-gray-500 text-center py-4">Tidak ada data pendapatan penyelenggara</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Pelanggan Teratas -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Pelanggan Teratas</h3>
        <div class="space-y-3">
            @forelse($topCustomers as $customer)
            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                <div class="flex-1">
                    <h4 class="font-medium text-gray-800">{{ $customer->name }}</h4>
                    <p class="text-sm text-gray-500">{{ $customer->email }}</p>
                </div>
                <span class="font-semibold text-indigo-600">
                    Rp {{ number_format($customer->total_spent, 0, ',', '.') }}
                </span>
            </div>
            @empty
            <p class="text-gray-500 text-center py-4">Tidak ada data pengeluaran pelanggan</p>
            @endforelse
        </div>
    </div>

    <!-- Grafik Pendapatan Harian (Tabel Sederhana) -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Pendapatan Harian (Pemesanan Disetujui)</h3>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Tanggal</th>
                        <th class="px-4 py-2 text-right text-sm font-medium text-gray-700">Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dailyRevenue as $daily)
                    <tr class="border-b border-gray-200">
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $daily->date }}</td>
                        <td class="px-4 py-3 text-sm text-right font-semibold text-green-600">
                            Rp {{ number_format($daily->total, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="px-4 py-4 text-center text-gray-500">Tidak ada data pendapatan harian</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Validasi tanggal sederhana
    document.addEventListener('DOMContentLoaded', function() {
        const startDate = document.querySelector('input[name="start_date"]');
        const endDate = document.querySelector('input[name="end_date"]');
        
        startDate.addEventListener('change', function() {
            endDate.min = this.value;
        });
        
        endDate.addEventListener('change', function() {
            startDate.max = this.value;
        });
    });
</script>
@endpush
@endsection