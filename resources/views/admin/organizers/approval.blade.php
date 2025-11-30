{{-- resources/views/admin/organizers/approval.blade.php --}}
@extends('layouts.admin')

@section('header', 'Persetujuan Organizer')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-green-600 to-blue-600 px-6 py-4">
            <h2 class="text-xl font-bold text-white">Organizer Disetujui</h2>
        </div>

        <div class="p-6 text-center">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-check-circle text-green-600 text-3xl"></i>
            </div>
            
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Persetujuan Berhasil!</h3>
            <p class="text-gray-600 mb-6">
                Organizer telah disetujui dan sekarang dapat membuat acara di platform.
            </p>

            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <div class="flex items-center justify-center mb-3">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white font-semibold mr-3">
                        {{ substr($organizer->name, 0, 1) }}
                    </div>
                    <div class="text-left">
                        <div class="font-semibold text-gray-900">{{ $organizer->name }}</div>
                        <div class="text-sm text-gray-500">{{ $organizer->email }}</div>
                    </div>
                </div>
                @if($organizer->organizer_description)
                    <p class="text-sm text-gray-600 italic">"{{ $organizer->organizer_description }}"</p>
                @endif
            </div>

            <div class="flex justify-center space-x-4">
                <a href="{{ route('admin.organizers.approval') }}" 
                   class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 font-medium transition-colors">
                    <i class="fas fa-list mr-2"></i> Kembali ke Persetujuan
                </a>
                <a href="{{ route('admin.users.show', $organizer) }}" 
                   class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 font-medium transition-colors">
                    <i class="fas fa-user mr-2"></i> Lihat Profil
                </a>
            </div>
        </div>
    </div>
</div>
@endsection