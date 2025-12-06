{{-- resources/views/components/ui/alert.blade.php --}}
@props([
    'type' => 'info',
    'dismissible' => false,
])

@php
    $styles = [
        'success' => 'bg-green-50 border-green-200 text-green-800',
        'error' => 'bg-red-50 border-red-200 text-red-800',
        'warning' => 'bg-yellow-50 border-yellow-200 text-yellow-800',
        'info' => 'bg-blue-50 border-blue-200 text-blue-800',
    ];
    
    $icons = [
        'success' => 'fas fa-check-circle',
        'error' => 'fas fa-exclamation-circle',
        'warning' => 'fas fa-exclamation-triangle',
        'info' => 'fas fa-info-circle',
    ];
@endphp

<div x-data="{ show: true }" x-show="show" 
     class="rounded-xl border p-4 {{ $styles[$type] }} transition-all duration-300"
     role="alert">
    <div class="flex items-start">
        <i class="{{ $icons[$type] }} mt-0.5 mr-3 text-lg"></i>
        <div class="flex-1">
            <div class="font-semibold">{{ $title ?? ucfirst($type) }}</div>
            <div class="text-sm mt-1">{{ $slot }}</div>
        </div>
        @if($dismissible)
            <button @click="show = false" class="ml-4 text-gray-500 hover:text-gray-700 transition-colors">
                <i class="fas fa-times"></i>
            </button>
        @endif
    </div>
</div>