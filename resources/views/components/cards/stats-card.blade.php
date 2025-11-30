{{-- resources/views/components/cards/stats-card.blade.php --}}
@props([
    'title',
    'value',
    'icon' => 'fas fa-chart-line',
    'color' => 'blue'
])

@php
    $colorClasses = [
        'blue' => 'bg-blue-100 text-blue-600',
        'green' => 'bg-green-100 text-green-600', 
        'purple' => 'bg-purple-100 text-purple-600',
        'orange' => 'bg-orange-100 text-orange-600',
        'red' => 'bg-red-100 text-red-600'
    ];
@endphp

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
    <div class="flex items-center">
        <div class="w-12 h-12 {{ $colorClasses[$color] ?? 'bg-blue-100 text-blue-600' }} rounded-lg flex items-center justify-center mr-4">
            <i class="{{ $icon }} text-xl"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500">{{ $title }}</p>
            <p class="text-2xl font-bold text-gray-800">{{ $value }}</p>
        </div>
    </div>
</div>