{{-- resources/views/components/ui/loading.blade.php --}}
@props([
    'size' => 'medium',
    'text' => null,
])

@php
    $sizes = [
        'small' => 'w-4 h-4',
        'medium' => 'w-8 h-8', 
        'large' => 'w-12 h-12',
    ];
    
    $sizeClass = $sizes[$size] ?? $sizes['medium'];
@endphp

<div class="flex flex-col items-center justify-center p-4">
    <div class="{{ $sizeClass }} border-4 border-gray-200 border-t-[#00A3FF] rounded-full animate-spin"></div>
    @if($text)
        <p class="mt-2 text-sm text-gray-600 font-medium">{{ $text }}</p>
    @endif
</div>