{{-- resources/views/components/ui/modal.blade.php --}}
@props([
    'name' => 'modal',
    'title' => null,
    'size' => 'medium',
])

@php
    $sizes = [
        'small' => 'max-w-md',
        'medium' => 'max-w-2xl',
        'large' => 'max-w-4xl',
        'full' => 'max-w-full mx-4',
    ];
@endphp

<div x-data="{ open: false }" 
     x-on:open-modal-{{ $name }}.window="open = true"
     x-on:close-modal-{{ $name }}.window="open = false"
     x-show="open"
     class="fixed inset-0 z-50 overflow-y-auto"
     style="display: none;">
     
    <!-- Overlay -->
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" x-show="open" 
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
    </div>

    <!-- Modal Panel -->
    <div class="flex min-h-full items-center justify-center p-4">
        <div x-show="open"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="relative bg-white rounded-2xl shadow-xl w-full {{ $sizes[$size] }} transform transition-all">
             
            <!-- Header -->
            @if($title)
                <div class="flex items-center justify-between p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $title }}</h3>
                    <button @click="open = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            @endif

            <!-- Content -->
            <div class="p-6">
                {{ $slot }}
            </div>

            <!-- Footer (optional) -->
            @if(isset($footer))
                <div class="flex justify-end space-x-3 p-6 border-t border-gray-200 bg-gray-50 rounded-b-2xl">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>