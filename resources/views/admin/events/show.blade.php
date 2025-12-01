@extends('layouts.admin')

@section('header', 'Detail Acara')

@section('content')
<div class="space-y-8">
    <!-- Breadcrumb -->
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-3">
            <li class="flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-lg font-medium text-gray-500 hover:text-[#262363] transition-colors">
                    Dashboard
                </a>
            </li>
            <li class="flex items-center">
                <i class="fas fa-chevron-right text-gray-400 mx-3 text-sm"></i>
                <a href="{{ route('admin.events.index') }}" class="text-lg font-medium text-gray-500 hover:text-[#262363] transition-colors">
                    Acara
                </a>
            </li>
            <li class="flex items-center">
                <i class="fas fa-chevron-right text-gray-400 mx-3 text-sm"></i>
                <span class="text-lg font-medium text-[#262363]">{{ $event->name }}</span>
            </li>
        </ol>
    </nav>

    <!-- Header dengan Actions -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold text-gray-900">{{ $event->name }}</h1>
            <p class="text-gray-600 mt-3 text-lg">Detail dan statistik acara</p>
        </div>
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.events.edit', $event) }}" 
               class="inline-flex items-center px-6 py-4 border-2 border-[#262363] text-[#262363] rounded-2xl hover:bg-[#262363] hover:text-white transition-all duration-300 font-bold text-lg">
                <i class="fas fa-edit mr-3"></i>
                Edit Acara
            </a>
            <a href="{{ route('admin.events.tickets.create', $event) }}" 
               class="inline-flex items-center px-6 py-4 px-6 py-3 bg-[#e6527b] text-white rounded-lg hover:bg-[#d9416d] font-medium transition-colors shadow-lg hover:shadow-xl">  
                <i class="fas fa-plus mr-3"></i>
                Tambah Tiket
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-200">
            <div class="flex items-center">
                <div class="p-4 rounded-xl bg-blue-100 text-blue-600">
                    <i class="fas fa-ticket-alt text-2xl"></i>
                </div>
                <div class="ml-6">
                    <p class="text-lg font-medium text-gray-600">Total Tiket</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalTickets }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-200">
            <div class="flex items-center">
                <div class="p-4 rounded-xl bg-green-100 text-green-600">
                    <i class="fas fa-shopping-cart text-2xl"></i>
                </div>
                <div class="ml-6">
                    <p class="text-lg font-medium text-gray-600">Tiket Terjual</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $soldTickets }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-200">
            <div class="flex items-center">
                <div class="p-4 rounded-xl bg-purple-100 text-purple-600">
                    <i class="fas fa-money-bill-wave text-2xl"></i>
                </div>
                <div class="ml-6">
                    <p class="text-lg font-medium text-gray-600">Total Pendapatan</p>
                    <p class="text-3xl font-bold text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-200">
            <div class="flex items-center">
                <div class="p-4 rounded-xl bg-orange-100 text-orange-600">
                    <i class="fas fa-calendar-check text-2xl"></i>
                </div>
                <div class="ml-6">
                    <p class="text-lg font-medium text-gray-600">Total Pemesanan</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalBookings }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        <!-- Event Details -->
        <div class="xl:col-span-2 space-y-8">
            <!-- Event Information -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-[#262363] to-[#00183c]">
                    <h2 class="text-2xl font-bold text-white">Informasi Acara</h2>
                </div>
                <div class="p-8">
                    <div class="flex flex-col lg:flex-row gap-8">
                        <!-- Event Image -->
                        <div class="flex-shrink-0">
                            @if($event->image)
                                <img src="{{ asset('storage/' . $event->image) }}" 
                                     alt="{{ $event->name }}"
                                     class="w-80 h-60 rounded-2xl object-cover shadow-xl">
                            @else
                                <div class="w-80 h-60 bg-gray-200 rounded-2xl flex items-center justify-center shadow-xl">
                                    <i class="fas fa-calendar text-5xl text-gray-400"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Event Details -->
                        <div class="flex-1 space-y-6">
                            <div>
                                <h3 class="text-3xl font-bold text-gray-900">{{ $event->name }}</h3>
                                <div class="flex items-center mt-4 space-x-6">
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-lg font-bold 
                                        {{ $event->status === 'published' ? 'bg-green-100 text-green-800 border border-green-200' : 
                                           ($event->status === 'draft' ? 'bg-yellow-100 text-yellow-800 border border-yellow-200' : 'bg-red-100 text-red-800 border border-red-200') }}">
                                        <i class="fas fa-circle mr-2 text-sm"></i>
                                        {{ $event->status === 'published' ? 'Published' : 
                                           ($event->status === 'draft' ? 'Draft' : 'Cancelled') }}
                                    </span>
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-lg font-bold 
                                        {{ $event->isPast() ? 'bg-gray-100 text-gray-800 border border-gray-200' : 'bg-blue-100 text-blue-800 border border-blue-200' }}">
                                        <i class="fas fa-clock mr-2 text-sm"></i>
                                        {{ $event->isPast() ? 'Acara Selesai' : 'Akan Datang' }}
                                    </span>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 text-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-day text-gray-400 mr-4 w-6"></i>
                                    <div>
                                        <p class="font-bold text-gray-700">Tanggal & Waktu</p>
                                        <p class="text-gray-600">{{ $event->event_date->format('l, j F Y \\p\\a\\d\\a H:i') }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center">
                                    <i class="fas fa-map-marker-alt text-gray-400 mr-4 w-6"></i>
                                    <div>
                                        <p class="font-bold text-gray-700">Lokasi</p>
                                        <p class="text-gray-600">{{ $event->location }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center">
                                    <i class="fas fa-tags text-gray-400 mr-4 w-6"></i>
                                    <div>
                                        <p class="font-bold text-gray-700">Kategori</p>
                                        <div class="flex items-center">
                                            @if($event->category->icon)
                                                <div class="w-6 h-6 rounded mr-3 flex items-center justify-center text-white text-sm"
                                                     style="background-color: {{ $event->category->color }}">
                                                    <i class="{{ $event->category->icon }}"></i>
                                                </div>
                                            @endif
                                            <span class="text-gray-600">{{ $event->category->name }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center">
                                    <i class="fas fa-user text-gray-400 mr-4 w-6"></i>
                                    <div>
                                        <p class="font-bold text-gray-700">Organizer</p>
                                        <p class="text-gray-600">{{ $event->organizer->name }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mt-8">
                        <h4 class="text-2xl font-bold text-gray-800 mb-4">Deskripsi</h4>
                        <div class="prose max-w-none text-gray-700 bg-gray-50 rounded-2xl p-6 text-lg">
                            {!! nl2br(e($event->description)) !!}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tickets Section -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-bold text-gray-800">Tiket Acara</h2>
                        <a href="{{ route('admin.events.tickets.create', $event) }}" 
                           class="inline-flex items-center px-6 py-4  bg-[#e6527b] text-white rounded-lg hover:bg-[#d9416d] font-medium transition-colors shadow-lg hover:shadow-xl">
                            <i class="fas fa-plus mr-3"></i>
                            Tambah Tiket
                        </a>
                    </div>
                </div>
                <div class="p-8">
                    @if($event->tickets->count() > 0)
                        <div class="space-y-6">
                            @foreach($event->tickets as $ticket)
                                <div class="border-2 border-gray-200 rounded-2xl p-6 hover:shadow-xl transition-shadow duration-300">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h4 class="text-xl font-bold text-gray-900">{{ $ticket->name }}</h4>
                                            <p class="text-lg text-gray-600 mt-2">{{ $ticket->description }}</p>
                                            <div class="flex items-center space-x-6 mt-4 text-lg">
                                                @if($ticket->image)
                                                    <img src="{{ asset('storage/' . $ticket->image) }}" 
                                                         alt="{{ $ticket->name }}"
                                                         class="w-24 h-24 rounded-xl object-cover flex-shrink-0 border-2 border-gray-300">
                                                @else
                                                    <div class="w-24 h-24 bg-gray-200 rounded-xl flex items-center justify-center flex-shrink-0">
                                                        <i class="fas fa-ticket-alt text-gray-400 text-2xl"></i>
                                                    </div>
                                                @endif
                                                <span class="text-green-600 font-bold">Rp {{ number_format($ticket->price, 0, ',', '.') }}</span>
                                                <span class="text-gray-500">Kuota: {{ $ticket->quota }}</span>
                                                <span class="text-blue-600">Tersedia: {{ $ticket->quota_remaining }}</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            <a href="{{ route('admin.tickets.edit', $ticket) }}" 
                                               class="inline-flex items-center px-4 py-2 border border-[#262363] text-white-600 rounded-xl hover:bg-[#262363] hover:text-white transition-all duration-300 text-lg">
                                                <i class="fas fa-edit mr-2"></i>
                                                Edit
                                            </a>
                                                <form action="{{ route('admin.tickets.destroy', $ticket) }}" method="POST"  onsubmit="return confirm('Hapus tiket {{ $ticket->name }}? {{ $ticket->bookings()->count() > 0 ? 'Ini akan menghapus ' . $ticket->bookings()->count() . ' booking yang terkait.' : '' }}')">
                                                    @csrf
                                                     @method('DELETE')
                                                     <button type="submit" 
                                                     class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-all duration-300 text-lg">
                                                     <i class="fas fa-trash mr-2"></i>
                                                     Hapus
                                                    </button>
                                              </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i class="fas fa-ticket-alt text-5xl text-gray-300 mb-6"></i>
                            <p class="text-gray-600 text-xl">Belum ada tiket untuk acara ini.</p>
                            <a href="{{ route('admin.events.tickets.create', $event) }}" 
                               class="inline-flex items-center px-8 py-4 bg-[#e692b7] text-white rounded-2xl hover:bg-[#d87ba8] transition-all duration-300 font-bold text-xl shadow-xl hover:shadow-2xl mt-6">
                                <i class="fas fa-plus mr-3"></i>
                                Buat Tiket Pertama
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-8">
            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                    <h2 class="text-2xl font-bold text-gray-800">Aksi Cepat</h2>
                </div>
                <div class="p-6 space-y-4">
                    <a href="{{ route('admin.bookings.index') }}?event={{ $event->id }}" 
                       class="flex items-center p-4 border-2 border-gray-200 rounded-xl hover:bg-gray-50 transition-colors duration-300">
                        <i class="fas fa-list text-blue-500 text-xl mr-4"></i>
                        <span class="font-bold text-gray-700 text-lg">Lihat Pemesanan</span>
                    </a>
                    <a href="{{ route('admin.events.edit', $event) }}" 
                       class="flex items-center p-4 border-2 border-gray-200 rounded-xl hover:bg-gray-50 transition-colors duration-300">
                        <i class="fas fa-edit text-green-500 text-xl mr-4"></i>
                        <span class="font-bold text-gray-700 text-lg">Edit Acara</span>
                    </a>
                    <a href="{{ route('admin.events.tickets.create', $event) }}" 
                       class="flex items-center p-4 border-2 border-gray-200 rounded-xl hover:bg-gray-50 transition-colors duration-300">
                        <i class="fas fa-plus text-purple-500 text-xl mr-4"></i>
                        <span class="font-bold text-gray-700 text-lg">Kelola Tiket</span>
                    </a>
                </div>
            </div>

            <!-- Event Timeline -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                    <h2 class="text-2xl font-bold text-gray-800">Timeline Acara</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-6">
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-green-500 rounded-full mr-4"></div>
                            <div>
                                <p class="font-bold text-gray-700 text-lg">Dibuat</p>
                                <p class="text-gray-500 text-lg">{{ $event->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-blue-500 rounded-full mr-4"></div>
                            <div>
                                <p class="font-bold text-gray-700 text-lg">Terakhir Diupdate</p>
                                <p class="text-gray-500 text-lg">{{ $event->updated_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-purple-500 rounded-full mr-4"></div>
                            <div>
                                <p class="font-bold text-gray-700 text-lg">Tanggal Acara</p>
                                <p class="text-gray-500 text-lg">{{ $event->event_date->format('j M Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection