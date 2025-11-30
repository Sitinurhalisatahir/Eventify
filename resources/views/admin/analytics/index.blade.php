{{-- resources/views/admin/analytics/index.blade.php --}}
@extends('layouts.admin')

@section('header', 'Dashboard Analitik')

@section('content')
<div class="space-y-6">

    <!-- Filter Periode -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            <i class="fas fa-calendar-alt mr-2 text-blue-600"></i>
            Periode Analitik
        </h3>
        <form method="GET" class="flex items-center gap-4">
            <select name="period" class="w-48 rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition-all">
                <option value="3months" {{ $period == '3months' ? 'selected' : '' }}>3 Bulan Terakhir</option>
                <option value="6months" {{ $period == '6months' ? 'selected' : '' }}>6 Bulan Terakhir</option>
                <option value="12months" {{ $period == '12months' ? 'selected' : '' }}>12 Bulan Terakhir</option>
            </select>
            <button type="submit" class="bg-gradient-to-r from-[#262363] to-[#262363] text-white px-6 py-2 rounded-lg hover:from-[#262363] hover:to-[#262363] font-medium transition-all shadow-l hover:shadow-xl">
                <i class="fas fa-filter mr-2"></i>Terapkan Filter
            </button>
        </form>
    </div>

    <!-- Metrik Utama -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <x-cards.stats-card 
            title="Total Pendapatan" 
            value="Rp {{ number_format($keyMetrics['total_revenue'], 0, ',', '.') }}"
            icon="fas fa-money-bill-wave"
            color="green" />

        <x-cards.stats-card 
            title="Total Pemesanan" 
            value="{{ number_format($keyMetrics['total_bookings'], 0, ',', '.') }}"
            icon="fas fa-shopping-cart"
            color="blue" />

        <x-cards.stats-card 
            title="Total Pengguna" 
            value="{{ number_format($keyMetrics['total_users'], 0, ',', '.') }}"
            icon="fas fa-users"
            color="purple" />

        <x-cards.stats-card 
            title="Pertumbuhan Pendapatan" 
            value="{{ $keyMetrics['revenue_growth_rate'] }}%"
            icon="fas {{ $keyMetrics['revenue_growth_rate'] >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }}"
            color="{{ $keyMetrics['revenue_growth_rate'] >= 0 ? 'green' : 'red' }}" />
    </div>

    <!-- Tambahkan di bagian mana saja setelah Metrik Utama -->

<!-- Pendapatan Organizer/EO -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">
        <i class="fas fa-building mr-2 text-indigo-600"></i>
        Pendapatan Organizer/EO
    </h3>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Nama Organizer</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Email</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Total Acara</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Total Pendapatan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($organizerRevenue as $organizer)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full flex items-center justify-center text-white mr-3">
                                <i class="fas fa-building text-sm"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 text-sm">{{ $organizer->name }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $organizer->email }}</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                            {{ $organizer->events_count }} acara
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <span class="font-semibold text-green-600 text-sm">
                            Rp {{ number_format($organizer->total_revenue, 0, ',', '.') }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

    <!-- Grid Grafik -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Histogram Pendapatan -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-chart-bar mr-2 text-blue-600"></i>
                Tren Pendapatan Bulanan
            </h3>
            
            @if($monthlyRevenueTrend->count() > 0)
                <div class="h-80">
                    <canvas id="revenueChart"></canvas>
                </div>
            @else
                <div class="h-80 flex items-center justify-center bg-gray-50 rounded-lg border border-gray-200">
                    <div class="text-center text-gray-500">
                        <i class="fas fa-chart-bar text-5xl mb-3 text-gray-300"></i>
                        <p class="font-semibold">Belum Ada Data Pendapatan</p>
                        <p class="text-sm mt-1">Buat beberapa pemesanan yang disetujui untuk melihat analitik pendapatan</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Histogram Pertumbuhan Pengguna -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-chart-bar mr-2 text-green-600"></i>
                Tren Pertumbuhan Pengguna
            </h3>
            
            @if($userGrowthTrend->count() > 0)
                <div class="h-80">
                    <canvas id="userGrowthChart"></canvas>
                </div>
            @else
                <div class="h-80 flex items-center justify-center bg-gray-50 rounded-lg border border-gray-200">
                    <div class="text-center text-gray-500">
                        <i class="fas fa-users text-5xl mb-3 text-gray-300"></i>
                        <p class="font-semibold">Tidak Ada Data Pertumbuhan Pengguna</p>
                        <p class="text-sm mt-1">Data pendaftaran pengguna akan muncul di sini</p>
                    </div>
                </div>
            @endif
        </div>

    </div>

    <!-- Distribusi Status Pemesanan -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-chart-pie mr-2 text-purple-600"></i>
                Distribusi Status Pemesanan
            </h3>
            <div class="grid grid-cols-2 gap-4">
                @foreach($bookingStatusDistribution as $status => $count)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200 hover:border-blue-500 transition-all">
                    <div class="flex items-center">
                        <div class="w-4 h-4 rounded-full mr-3 
                            {{ $status === 'approved' ? 'bg-green-500' : 
                               ($status === 'pending' ? 'bg-yellow-500' : 
                               ($status === 'cancelled' ? 'bg-red-500' : 'bg-gray-500')) }}"></div>
                        <span class="text-sm font-medium text-gray-700 capitalize">
                            {{ $status === 'approved' ? 'Disetujui' : 
                               ($status === 'pending' ? 'Tertunda' : 
                               ($status === 'cancelled' ? 'Dibatalkan' : 'Ditolak')) }}
                        </span>
                    </div>
                    <span class="text-xl font-bold text-gray-900">{{ $count }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Metrik Rata-rata -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-calculator mr-2 text-orange-600"></i>
                Metrik Rata-rata
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border border-green-200">
                    <span class="text-gray-700 font-medium">Nilai Rata-rata Pemesanan</span>
                    <span class="font-bold text-green-600 text-lg">Rp {{ number_format($keyMetrics['avg_booking_value'], 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center p-4 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-lg border border-blue-200">
                    <span class="text-gray-700 font-medium">Acara Diterbitkan</span>
                    <span class="font-bold text-blue-600 text-lg">{{ $keyMetrics['total_events'] }}</span>
                </div>
                <div class="flex justify-between items-center p-4 bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg border border-purple-200">
                    <span class="text-gray-700 font-medium">Tingkat Pertumbuhan Pendapatan</span>
                    <span class="font-bold {{ $keyMetrics['revenue_growth_rate'] >= 0 ? 'text-green-600' : 'text-red-600' }} text-lg">
                        {{ $keyMetrics['revenue_growth_rate'] >= 0 ? '+' : '' }}{{ $keyMetrics['revenue_growth_rate'] }}%
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Pendapatan Organizer/EO -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            <i class="fas fa-building mr-2 text-indigo-600"></i>
            Pendapatan Organizer/EO
        </h3>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Nama Organizer</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Email</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Total Acara</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Total Pendapatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($organizerRevenue as $organizer)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full flex items-center justify-center text-white mr-3">
                                    <i class="fas fa-building text-sm"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 text-sm">{{ $organizer->name }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $organizer->email }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                {{ $organizer->events_count }} acara
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="font-semibold text-green-600 text-sm">
                                Rp {{ number_format($organizer->total_revenue, 0, ',', '.') }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tabel Kinerja Acara -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            <i class="fas fa-trophy mr-2 text-yellow-600"></i>
            Acara dengan Kinerja Terbaik
        </h3>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Acara</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Pemesanan</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Tingkat Pemesanan</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Rating Rata-rata</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($eventPerformance as $performance)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3">
                            <div class="flex items-center">
                                @if($performance['event']->image)
                                    <img src="{{ asset('storage/' . $performance['event']->image) }}" 
                                         alt="{{ $performance['event']->name }}"
                                         class="w-12 h-12 rounded-lg object-cover mr-3 border border-gray-200">
                                @else
                                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-500 rounded-lg flex items-center justify-center text-white mr-3">
                                        <i class="fas fa-calendar text-lg"></i>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-semibold text-gray-900 text-sm">{{ $performance['event']->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $performance['event']->organizer->name }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                <i class="fas fa-ticket-alt mr-1"></i>
                                {{ $performance['bookings_count'] }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center">
                                <div class="w-20 bg-gray-200 rounded-full h-2 mr-2">
                                    <div class="bg-gradient-to-r from-green-500 to-emerald-600 h-2 rounded-full" style="width: {{ $performance['booking_rate'] }}%"></div>
                                </div>
                                <span class="text-sm font-semibold text-gray-700">{{ round($performance['booking_rate'], 1) }}%</span>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star text-{{ $i <= $performance['avg_rating'] ? 'yellow-400' : 'gray-300' }} text-sm"></i>
                                @endfor
                                <span class="ml-2 text-sm font-semibold text-gray-600">({{ $performance['avg_rating'] }})</span>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Kinerja Kategori -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            <i class="fas fa-layer-group mr-2 text-indigo-600"></i>
            Kinerja Kategori
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($categoryPerformance as $performance)
            <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-500 hover:shadow-md transition-all">
                <div class="flex items-center mb-3">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-3" style="background-color: {{ $performance['category']->color }}20;">
                        <i class="{{ $performance['category']->icon }} text-lg" style="color: {{ $performance['category']->color }};"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900">{{ $performance['category']->name }}</h4>
                </div>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Pemesanan:</span>
                        <span class="font-semibold text-blue-600">{{ $performance['total_bookings'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Pendapatan:</span>
                        <span class="font-semibold text-green-600">Rp {{ number_format($performance['total_revenue'], 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Acara:</span>
                        <span class="font-semibold text-purple-600">{{ $performance['category']->events_count }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
// Siapkan data dari Laravel
const revenueData = @json($monthlyRevenueTrend);
const userGrowthData = @json($userGrowthTrend);

// Grafik Pendapatan (Histogram)
@if($monthlyRevenueTrend->count() > 0)
const revenueCtx = document.getElementById('revenueChart');
new Chart(revenueCtx, {
    type: 'bar',
    data: {
        labels: revenueData.map(item => item.month),
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: revenueData.map(item => item.revenue),
            backgroundColor: 'rgba(59, 130, 246, 0.8)',
            borderColor: 'rgba(59, 130, 246, 1)',
            borderWidth: 2,
            borderRadius: 8,
            hoverBackgroundColor: 'rgba(37, 99, 235, 0.9)',
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        animation: false,
        plugins: {
            legend: {
                display: true,
                position: 'top',
                labels: {
                    font: {
                        size: 12,
                        weight: 'bold'
                    }
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                titleFont: {
                    size: 14,
                    weight: 'bold'
                },
                bodyFont: {
                    size: 13
                },
                padding: 12,
                cornerRadius: 8,
                callbacks: {
                    label: function(context) {
                        return 'Pendapatan: Rp ' + context.parsed.y.toLocaleString('id-ID');
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        if (value >= 1000000) {
                            return 'Rp ' + (value / 1000000).toFixed(1) + ' jt';
                        } else if (value >= 1000) {
                            return 'Rp ' + (value / 1000).toFixed(0) + ' rb';
                        } else {
                            return 'Rp ' + value;
                        }
                    },
                    font: {
                        size: 11
                    }
                },
                grid: {
                    color: 'rgba(0, 0, 0, 0.05)',
                }
            },
            x: {
                ticks: {
                    font: {
                        size: 11
                    }
                },
                grid: {
                    display: false
                }
            }
        }
    }
});
@endif

// Grafik Pertumbuhan Pengguna (Histogram)
@if($userGrowthTrend->count() > 0)
const userGrowthCtx = document.getElementById('userGrowthChart');
new Chart(userGrowthCtx, {
    type: 'bar',
    data: {
        labels: userGrowthData.map(item => item.month),
        datasets: [{
            label: 'Pengguna Baru',
            data: userGrowthData.map(item => item.users),
            backgroundColor: 'rgba(34, 197, 94, 0.8)',
            borderColor: 'rgba(34, 197, 94, 1)',
            borderWidth: 2,
            borderRadius: 8,
            hoverBackgroundColor: 'rgba(22, 163, 74, 0.9)',
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        animation: false,
        plugins: {
            legend: {
                display: true,
                position: 'top',
                labels: {
                    font: {
                        size: 12,
                        weight: 'bold'
                    }
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                titleFont: {
                    size: 14,
                    weight: 'bold'
                },
                bodyFont: {
                    size: 13
                },
                padding: 12,
                cornerRadius: 8,
                callbacks: {
                    label: function(context) {
                        return 'Pengguna Baru: ' + context.parsed.y;
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1,
                    font: {
                        size: 11
                    }
                },
                grid: {
                    color: 'rgba(0, 0, 0, 0.05)',
                }
            },
            x: {
                ticks: {
                    font: {
                        size: 11
                    }
                },
                grid: {
                    display: false
                }
            }
        }
    }
});
@endif
</script>
@endpush