{{-- resources/views/admin/users/index.blade.php --}}
@extends('layouts.admin')

@section('header', 'Manajemen Pengguna')

@section('content')
<div class="space-y-6">
    <!-- Kartu Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-users text-[#262363] text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Pengguna</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-user-check text-green-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Organizer</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalOrganizers }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-shield-alt text-[#262363] text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Admin</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalAdmins }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Pencarian -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <form method="GET" action="{{ route('admin.users.index') }}" id="filterForm" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Pencarian -->
                <div>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Cari berdasarkan nama atau email..."
                           class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-[#262363] focus:ring-2 focus:ring-[#262363] transition-all duration-300 outline-none">
                </div>

                <!-- Filter Peran -->
                <div>
                    <select name="role" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-[#262363] focus:ring-2 focus:ring-[#262363] transition-all duration-300 outline-none">
                        <option value="">Semua Peran</option>
                        <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>Pengguna</option>
                        <option value="organizer" {{ request('role') == 'organizer' ? 'selected' : '' }}>Organizer</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>
            </div>
            <div class="flex gap-2">
                <button type="submit" 
                        class="bg-[#262363] text-white px-6 py-2 rounded-lg hover:bg-[#00183c] font-medium transition-colors">
                    <i class="fas fa-search mr-2"></i> Filter
                </button>
                <a href="{{ route('admin.users.index') }}" 
                   class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 font-medium transition-colors">
                    Hapus
                </a>
            </div>
        </form>
    </div>

    <!-- Tabel Pengguna -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Semua Pengguna</h3>
        </div>

        @if($users->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengguna</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peran</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bergabung</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($users as $user)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-r from-[#262363] to-[#00183c] rounded-full flex items-center justify-center text-white font-semibold mr-3">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 
                                           ($user->role === 'organizer' ? 'bg-green-100 text-green-800' : 
                                           'bg-blue-100 text-blue-800') }}">
                                        {{ $user->role === 'admin' ? 'Admin' : 
                                           ($user->role === 'organizer' ? 'Organizer' : 'Pengguna') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($user->role === 'organizer')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            {{ $user->organizer_status === 'approved' ? 'bg-green-100 text-green-800' : 
                                               ($user->organizer_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                               'bg-red-100 text-red-800') }}">
                                            {{ $user->organizer_status === 'approved' ? 'Disetujui' : 
                                               ($user->organizer_status === 'pending' ? 'Menunggu' : 'Ditolak') }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            Aktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('admin.users.show', $user) }}" 
                                           class="bg-[#262363] text-white px-3 py-1 rounded-lg hover:bg-[#00183c] transition-colors inline-flex items-center">
                                            <i class="fas fa-eye mr-1"></i> Lihat
                                        </a>
                                        @if($user->role !== 'admin')
                                            <button onclick="confirmDelete({{ $user->id }})"
                                                    class="bg-red-600 text-white px-3 py-1 rounded-lg hover:bg-red-700 transition-colors inline-flex items-center">
                                                <i class="fas fa-trash mr-1"></i> Hapus
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $users->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-users text-gray-300 text-4xl mb-3"></i>
                <h3 class="text-lg font-semibold text-gray-600 mb-2">Tidak ada pengguna ditemukan</h3>
                <p class="text-gray-500">
                    @if(request('search') || request('role'))
                        Coba sesuaikan filter pencarian Anda
                    @else
                        Belum ada pengguna dalam sistem
                    @endif
                </p>
            </div>
        @endif
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div id="delete-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-2">Hapus Pengguna</h3>
            <p class="text-sm text-gray-500 mt-2">Apakah Anda yakin ingin menghapus pengguna ini? Tindakan ini tidak dapat dibatalkan.</p>
            <div class="flex justify-center space-x-4 mt-4">
                <button onclick="closeModal()"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                    Batal
                </button>
                <form id="delete-form" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(userId) {
    const modal = document.getElementById('delete-modal');
    const form = document.getElementById('delete-form');
    form.action = `/admin/users/${userId}`;
    modal.classList.remove('hidden');
}

function closeModal() {
    const modal = document.getElementById('delete-modal');
    modal.classList.add('hidden');
}

// Tutup modal ketika klik di luar
window.onclick = function(event) {
    const modal = document.getElementById('delete-modal');
    if (event.target === modal) {
        closeModal();
    }
}

// Auto-submit form ketika filter berubah
document.addEventListener('DOMContentLoaded', function() {
    const filterForm = document.getElementById('filterForm');
    const filterSelects = filterForm.querySelectorAll('select[name="role"]');
    
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            filterForm.submit();
        });
    });
    
    // Juga untuk search input dengan debounce
    const searchInput = filterForm.querySelector('input[name="search"]');
    let searchTimeout;
    
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            filterForm.submit();
        }, 500); // Submit setelah 500ms tidak mengetik
    });
});
</script>
@endsection