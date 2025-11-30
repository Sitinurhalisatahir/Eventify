{{-- resources/views/organizer/analytics/index.blade.php --}}
@extends('layouts.organizer')

@section('header', 'Analitik Acara')

@section('content')
<div class="space-y-6">
    
    <!-- Filter Periode -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            <i class="fas fa-calendar-alt mr-2 text-green-600"></i>
            Periode Analitik
        </h3>
        <form method="GET" class="flex items-center gap-4">
            <select name="period" class="w-48 rounded-lg border border-gray-300 px-4 py-2 focus:border-[#262363] focus:ring-2 focus:ring-[#262363] transition-all">
                <option value="3months" {{ $period == '3months' ? 'selected' : '' }}>3 Bulan Terakhir</option>
                <option value="6months" {{ $period == '6months' ? 'selected' : '' }}>6 Bulan Terakhir</option>
                <option value="12months" {{ $period == '12months' ? 'selected' : '' }}>12 Bulan Terakhir</option>
            </select>
            <button type="submit" class="bg-[#262363] text-white px-6 py-2 rounded-lg hover:bg-[#00183c] font-medium transition-all shadow-lg hover:shadow-xl">
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
            title="Acara Terbit" 
            value="{{ $keyMetrics['published_events'] }}/{{ $keyMetrics['total_events'] }}"
            icon="fas fa-calendar-check"
            color="purple" />

        <x-cards.stats-card 
            title="Pertumbuhan Pendapatan" 
            value="{{ $keyMetrics['revenue_growth_rate'] }}%"
            icon="fas {{ $keyMetrics['revenue_growth_rate'] >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }}"
            color="{{ $keyMetrics['revenue_growth_rate'] >= 0 ? 'green' : 'red' }}" />
    </div>

    <!-- Grid Chart -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Histogram Pendapatan -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-chart-bar mr-2 text-green-600"></i>
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
                        <p class="text-sm mt-1">Pendapatan akan muncul saat Anda mendapatkan pemesanan yang disetujui</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Histogram Pemesanan -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-chart-bar mr-2 text-blue-600"></i>
                Tren Pemesanan Bulanan
            </h3>
            
            @if($monthlyBookingsTrend->count() > 0)
                <div class="h-80">
                    <canvas id="bookingsChart"></canvas>
                </div>
            @else
                <div class="h-80 flex items-center justify-center bg-gray-50 rounded-lg border border-gray-200">
                    <div class="text-center text-gray-500">
                        <i class="fas fa-shopping-cart text-5xl mb-3 text-gray-300"></i>
                        <p class="font-semibold">Belum Ada Data Pemesanan</p>
                        <p class="text-sm mt-1">Data pemesanan akan muncul di sini</p>
                    </div>
                </div>
            @endif
        </div>

    </div>

    <!-- Performa Acara & Status Pemesanan -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Performa Acara -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-trophy mr-2 text-yellow-600"></i>
                Acara Berkinerja Terbaik
            </h3>
            
            @if($eventPerformance->count() > 0)
                <div class="space-y-4">
                    @foreach($eventPerformance as $performance)
                    <div class="border border-gray-200 rounded-lg p-4 hover:border-green-500 transition-all hover:shadow-md">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-semibold text-gray-900 text-sm">{{ $performance['event']->name }}</h4>
                            <span class="text-sm font-bold text-green-600">
                                Rp {{ number_format($performance['revenue'], 0, ',', '.') }}
                            </span>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 text-xs mb-2">
                            <div>
                                <p class="text-gray-600">Tiket Terjual</p>
                                <p class="font-semibold text-blue-600">
                                    {{ $performance['sold_tickets'] }}/{{ $performance['total_tickets'] }}
                                </p>
                            </div>
                            <div>
                                <p class="text-gray-600">Tingkat Pemesanan</p>
                                <p class="font-semibold text-green-600">
                                    {{ round($performance['booking_rate'], 1) }}%
                                </p>
                            </div>
                        </div>
                        
                        <!-- Progress Bar -->
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-gradient-to-r from-green-500 to-emerald-600 h-2 rounded-full" 
                                 style="width: {{ $performance['booking_rate'] }}%">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-calendar-times text-4xl mb-2 text-gray-300"></i>
                    <p class="font-semibold">Tidak Ada Data Performa Acara</p>
                    <p class="text-sm mt-1">Terbitkan acara untuk melihat analitik performa</p>
                </div>
            @endif
        </div>

        <!-- Distribusi Status Pemesanan -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-chart-pie mr-2 text-purple-600"></i>
                Distribusi Status Pemesanan
            </h3>
            
            @if($bookingStatusDistribution->count() > 0)
                <div class="space-y-3">
                    @foreach($bookingStatusDistribution as $status => $count)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200 hover:border-blue-500 transition-all">
                        <div class="flex items-center">
                            <div class="w-4 h-4 rounded-full mr-3 
                                {{ $status === 'approved' ? 'bg-green-500' : 
                                   ($status === 'pending' ? 'bg-yellow-500' : 
                                   ($status === 'cancelled' ? 'bg-red-500' : 'bg-gray-500')) }}">
                            </div>
                            <span class="text-sm font-medium text-gray-700 capitalize">
                                {{ $status === 'approved' ? 'Disetujui' : 
                                   ($status === 'pending' ? 'Menunggu' : 
                                   ($status === 'cancelled' ? 'Dibatalkan' : $status)) }}
                            </span>
                        </div>
                        <span class="text-xl font-bold text-gray-900">{{ $count }}</span>
                    </div>
                    @endforeach
                </div>

                <!-- Ringkasan Statistik -->
                <div class="mt-4 p-4 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-lg border border-blue-200">
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-600 font-medium">Tingkat Persetujuan</p>
                            <p class="font-bold text-green-600 text-lg">
                                @php
                                    $total = $bookingStatusDistribution->sum();
                                    $approved = $bookingStatusDistribution['approved'] ?? 0;
                                    $approvalRate = $total > 0 ? ($approved / $total) * 100 : 0;
                                @endphp
                                {{ round($approvalRate, 1) }}%
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-600 font-medium">Rata-rata Nilai Pemesanan</p>
                            <p class="font-bold text-purple-600 text-lg">
                                Rp {{ number_format($keyMetrics['avg_booking_value'], 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-shopping-cart text-4xl mb-2 text-gray-300"></i>
                    <p class="font-semibold">Tidak Ada Data Pemesanan</p>
                    <p class="text-sm mt-1">Status pemesanan akan muncul di sini</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Wawasan Cepat -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            <i class="fas fa-lightbulb mr-2 text-orange-600"></i>
            Wawasan Cepat
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div class="flex items-start">
                    <i class="fas fa-chart-line text-green-500 mt-1 mr-3 text-lg"></i>
                    <div>
                        <p class="font-semibold text-gray-900">Performa Pendapatan</p>
                        <p class="text-gray-600 text-sm">
                            @if($keyMetrics['revenue_growth_rate'] > 0)
                                Pendapatan Anda tumbuh {{ abs($keyMetrics['revenue_growth_rate']) }}% dibandingkan bulan lalu
                            @elseif($keyMetrics['revenue_growth_rate'] < 0)
                                Pendapatan Anda menurun {{ abs($keyMetrics['revenue_growth_rate']) }}% dibandingkan bulan lalu
                            @else
                                Pendapatan Anda stabil dibandingkan bulan lalu
                            @endif
                        </p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <i class="fas fa-ticket-alt text-blue-500 mt-1 mr-3 text-lg"></i>
                    <div>
                        <p class="font-semibold text-gray-900">Performa Acara</p>
                        <p class="text-gray-600 text-sm">
                            Anda memiliki {{ $keyMetrics['published_events'] }} acara terbit dari {{ $keyMetrics['total_events'] }} total acara
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="space-y-4">
                <div class="flex items-start">
                    <i class="fas fa-users text-purple-500 mt-1 mr-3 text-lg"></i>
                    <div>
                        <p class="font-semibold text-gray-900">Keterlibatan Pelanggan</p>
                        <p class="text-gray-600 text-sm">
                            {{ $keyMetrics['total_bookings'] }} total pemesanan dengan nilai rata-rata 
                            Rp {{ number_format($keyMetrics['avg_booking_value'], 0, ',', '.') }} per pemesanan
                        </p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <i class="fas fa-star text-orange-500 mt-1 mr-3 text-lg"></i>
                    <div>
                        <p class="font-semibold text-gray-900">Rekomendasi</p>
                        <p class="text-gray-600 text-sm">
                            @if($keyMetrics['published_events'] == 0)
                                Mulai dengan menerbitkan acara pertama Anda untuk menghasilkan pendapatan
                            @elseif($keyMetrics['total_bookings'] == 0)
                                Promosikan acara yang telah diterbitkan untuk menarik lebih banyak pemesanan
                            @else
                                Pertimbangkan untuk membuat lebih banyak acara untuk meningkatkan aliran pendapatan
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
// Siapkan data dari Laravel
const revenueData = @json($monthlyRevenueTrend);
const bookingsData = @json($monthlyBookingsTrend);

// Chart Pendapatan (Histogram) - TANPA ANIMASI
// Chart Pendapatan (Histogram) - TANPA ANIMASI
@if($monthlyRevenueTrend->count() > 0)
const revenueCtx = document.getElementById('revenueChart');
new Chart(revenueCtx, {
    type: 'bar',
    data: {
        labels: revenueData.map(item => item.month),
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: revenueData.map(item => item.revenue),
            backgroundColor: 'rgba(34, 197, 94, 0.8)',
            borderColor: 'rgba(34, 197, 94, 1)',
            borderWidth: 2,
            borderRadius: 8,
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
                        if (value === 0) return 'Rp 0';
                        
                        if (value >= 1000000) {
                            return 'Rp ' + (value / 1000000).toFixed(0) + ' Jt';
                        } else if (value >= 1000) {
                            return 'Rp ' + (value / 1000).toFixed(0) + ' Rb';
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

// Chart Pemesanan (Histogram) - TANPA ANIMASI
@if($monthlyBookingsTrend->count() > 0)
const bookingsCtx = document.getElementById('bookingsChart');
new Chart(bookingsCtx, {
    type: 'bar',
    data: {
        labels: bookingsData.map(item => item.month),
        datasets: [{
            label: 'Pemesanan',
            data: bookingsData.map(item => item.bookings),
            backgroundColor: 'rgba(59, 130, 246, 0.8)',
            borderColor: 'rgba(59, 130, 246, 1)',
            borderWidth: 2,
            borderRadius: 8,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        animation: false, // ✅ NONAKTIFKAN ANIMASI
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
                        return 'Pemesanan: ' + context.parsed.y;
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