{{-- resources/views/components/ui/badge.blade.php --}}
@props([
    'variant' => 'default',
    'size' => 'medium',
])

@php
    $baseClasses = 'inline-flex items-center font-medium rounded-full';
    
    $variants = [
        'default' => 'bg-gray-100 text-gray-800',
        'primary' => 'bg-gradient-to-r from-[#00A3FF] to-[#8A2BE2] text-white',
        'success' => 'bg-green-100 text-green-800',
        'warning' => 'bg-yellow-100 text-yellow-800',
        'danger' => 'bg-red-100 text-red-800',
        'outline' => 'border border-[#00A3FF] text-[#00A3FF]',
    ];
    
    $sizes = [
        'small' => 'px-2 py-1 text-xs',
        'medium' => 'px-3 py-1 text-sm',
        'large' => 'px-4 py-2 text-base',
    ];
@endphp

<span {{ $attributes->merge(['class' => $baseClasses . ' ' . $variants[$variant] . ' ' . $sizes[$size]]) }}>
    {{ $slot }}
</span>