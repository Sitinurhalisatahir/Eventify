{{-- resources/views/admin/organizers/index.blade.php --}}
@extends('layouts.admin')

@section('header', 'Persetujuan Organizer')

@section('content')
<div class="space-y-6">
    <!-- Kartu Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Menunggu Persetujuan</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $pendingCount }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Disetujui</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $approvedCount }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-times-circle text-red-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Ditolak</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $rejectedCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200">
        <div class="border-b border-gray-200">
            <nav class="flex -mb-px">
                <a href="{{ route('admin.organizers.approval', ['status' => 'pending']) }}" 
                   class="py-4 px-6 text-center border-b-2 font-medium text-sm {{ $status === 'pending' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <i class="fas fa-clock mr-2"></i>
                    Menunggu ({{ $pendingCount }})
                </a>
                <a href="{{ route('admin.organizers.approval', ['status' => 'approved']) }}" 
                   class="py-4 px-6 text-center border-b-2 font-medium text-sm {{ $status === 'approved' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <i class="fas fa-check-circle mr-2"></i>
                    Disetujui ({{ $approvedCount }})
                </a>
                <a href="{{ route('admin.organizers.approval', ['status' => 'rejected']) }}" 
                   class="py-4 px-6 text-center border-b-2 font-medium text-sm {{ $status === 'rejected' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <i class="fas fa-times-circle mr-2"></i>
                    Ditolak ({{ $rejectedCount }})
                </a>
            </nav>
        </div>

        <div class="p-6">
            @if($organizers->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Organizer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telepon</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Daftar</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($organizers as $organizer)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white font-semibold mr-3">
                                                {{ substr($organizer->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-900">{{ $organizer->name }}</div>
                                                @if($organizer->organizer_description)
                                                    <div class="text-sm text-gray-500 line-clamp-1">{{ $organizer->organizer_description }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $organizer->email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $organizer->phone ?? 'T/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $organizer->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            {{ $organizer->organizer_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                               ($organizer->organizer_status === 'approved' ? 'bg-green-100 text-green-800' : 
                                               'bg-red-100 text-red-800') }}">
                                            {{ $organizer->organizer_status === 'pending' ? 'Menunggu' : 
                                               ($organizer->organizer_status === 'approved' ? 'Disetujui' : 'Ditolak') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('admin.users.show', $organizer) }}" 
                                               class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-3 py-1 rounded-lg transition-colors">
                                                <i class="fas fa-eye mr-1"></i> Lihat
                                            </a>
                                            
                                            @if($organizer->organizer_status === 'pending')
                                                <form action="{{ route('admin.organizers.approve', $organizer) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="text-green-600 hover:text-green-900 bg-green-50 hover:bg-green-100 px-3 py-1 rounded-lg transition-colors"
                                                            onclick="return confirm('Setujui organizer ini? Mereka akan dapat membuat acara.')">
                                                        <i class="fas fa-check mr-1"></i> Setujui
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.organizers.reject', $organizer) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1 rounded-lg transition-colors"
                                                            onclick="return confirm('Tolak organizer ini? Mereka akan diberitahu dan dapat menghapus akun mereka.')">
                                                        <i class="fas fa-times mr-1"></i> Tolak
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $organizers->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-users text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada organizer ditemukan</h3>
                    <p class="text-gray-500">
                        @if($status === 'pending')
                            Tidak ada organizer yang menunggu persetujuan.
                        @elseif($status === 'approved')
                            Belum ada organizer yang disetujui.
                        @else
                            Tidak ada organizer yang ditolak.
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection