@props([
    'variant' => 'primary',
    'size' => 'medium',
    'type' => 'button',
    'disabled' => false,
    'href' => null, // TAMBAHKAN INI
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-semibold rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2';
    
    $variants = [
        'primary' => 'bg-gradient-to-r from-[#00A3FF] to-[#8A2BE2] text-white hover:from-[#0095E6] hover:to-[#7B1FA2] shadow-lg hover:shadow-xl focus:ring-[#00A3FF]',
        'secondary' => 'bg-gray-100 text-gray-700 hover:bg-gray-200 border border-gray-300 focus:ring-gray-500',
        'success' => 'bg-green-500 text-white hover:bg-green-600 focus:ring-green-500',
        'danger' => 'bg-red-500 text-white hover:bg-red-600 focus:ring-red-500',
        'outline' => 'border-2 border-[#00A3FF] text-[#00A3FF] hover:bg-[#00A3FF] hover:text-white focus:ring-[#00A3FF]',
    ];
    
    $sizes = [
        'small' => 'px-3 py-2 text-sm',
        'medium' => 'px-6 py-3 text-base',
        'large' => 'px-8 py-4 text-lg',
    ];
    
    $disabledClasses = 'opacity-50 cursor-not-allowed';
    
    $sizeClass = $sizes[$size] ?? $sizes['medium'];
    $variantClass = $variants[$variant] ?? $variants['primary'];
    $classes = $baseClasses . ' ' . $variantClass . ' ' . $sizeClass . ' ' . ($disabled ? $disabledClasses : '');
@endphp

@if($href)
    {{-- JIKA ADA HREF, PAKAI A TAG --}}
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    {{-- JIKA TIDAK ADA HREF, PAKAI BUTTON TAG --}}
    <button type="{{ $type }}" {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif