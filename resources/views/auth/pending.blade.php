<x-guest-layout>
    <div class="mb-4 text-center">
        @if(Auth::user()->organizer_status === 'pending')
            <!-- Icon untuk pending di tengah -->
            <div class="flex justify-center mb-4">
                <svg class="w-20 h-20 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>

            <h2 class="text-2xl font-bold text-gray-800 mb-6">Akun Sedang Ditinjau</h2>
            
            <!-- Kotak informasi di tengah -->
            <div class="max-w-md mx-auto mb-6">
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 text-center rounded-r-lg">
                    <div class="flex flex-col items-center">
                        <div class="mb-3">
                            <svg class="h-12 w-12 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-yellow-800 mb-2">
                                Akun penyelenggara Anda sedang ditinjau
                            </h3>
                            <p class="text-sm text-yellow-700">
                                Tim admin kami sedang memeriksa data akun Anda. Anda akan mendapatkan notifikasi via email setelah proses selesai.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Akun di tengah -->
            <div class="max-w-md mx-auto mb-6">
                <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 text-center">Detail Akun</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 font-medium">Nama:</span>
                            <span class="text-gray-800 font-semibold">{{ Auth::user()->name }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 font-medium">Email:</span>
                            <span class="text-gray-800 font-semibold">{{ Auth::user()->email }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 font-medium">Status:</span>
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded-full">
                                Menunggu Review
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info waktu proses di tengah -->
            <div class="max-w-md mx-auto">
                <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 text-center">
                    <div class="flex flex-col items-center">
                        <svg class="w-6 h-6 text-blue-500 mb-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-sm text-blue-700">
                            Proses review biasanya memakan waktu <strong>1-2 hari kerja</strong>.
                        </p>
                    </div>
                </div>
            </div>

        @elseif(Auth::user()->organizer_status === 'rejected')
            <!-- Icon untuk rejected di tengah -->
            <div class="flex justify-center mb-4">
                <svg class="w-20 h-20 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>

            <h2 class="text-2xl font-bold text-gray-800 mb-6">Akun Ditolak</h2>
            
            <!-- Kotak informasi reject di tengah -->
            <div class="max-w-md mx-auto mb-6">
                <div class="bg-red-50 border-l-4 border-red-500 p-6 text-center rounded-r-lg">
                    <div class="flex flex-col items-center">
                        <div class="mb-3">
                            <svg class="h-12 w-12 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-red-800 mb-2">
                                Aplikasi akun organizer Anda ditolak
                            </h3>
                            <p class="text-sm text-red-700">
                                Tim admin telah meninjau data Anda dan memutuskan untuk menolak aplikasi.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Akun di tengah -->
            <div class="max-w-md mx-auto mb-6">
                <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 text-center">Detail Akun</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 font-medium">Nama:</span>
                            <span class="text-gray-800 font-semibold">{{ Auth::user()->name }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 font-medium">Email:</span>
                            <span class="text-gray-800 font-semibold">{{ Auth::user()->email }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 font-medium">Status:</span>
                            <span class="px-3 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">
                                Ditolak
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hanya button Hapus Akun di tengah -->
            <div class="max-w-md mx-auto">
                <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Yakin ingin menghapus akun? Tindakan ini tidak dapat dibatalkan.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full inline-flex justify-center items-center px-6 py-3 bg-red-600 hover:bg-red-700 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-wider transition duration-200 shadow-sm hover:shadow">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Hapus Akun
                    </button>
                </form>
            </div>
        @endif
    </div>

    <!-- Logout Button di tengah -->
    <div class="max-w-md mx-auto mt-8">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full inline-flex justify-center items-center px-6 py-3 bg-gray-800 hover:bg-gray-900 border border-gray-700 rounded-lg font-semibold text-sm text-white uppercase tracking-wider transition duration-200 shadow hover:shadow-md">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                KELUAR
            </button>
        </form>
    </div>
</x-guest-layout>