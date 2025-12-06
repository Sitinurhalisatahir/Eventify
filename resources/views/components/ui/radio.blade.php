{{-- resources/views/components/ui/radio.blade.php --}}
@props([
    'label' => null,
    'error' => null,
    'helperText' => null,
    'checked' => false,
    'value' => null,
    'name' => null,
])

<div class="flex items-start space-x-3">
    <div class="flex items-center h-5">
        <input 
            type="radio"
            name="{{ $name }}"
            value="{{ $value }}"
            {{ $checked ? 'checked' : '' }}
            {{ $attributes->merge([
                'class' => 'w-4 h-4 text-[#00A3FF] bg-white border-gray-300 focus:ring-[#00A3FF] focus:ring-2 transition-all duration-200'
            ]) }}
        >
    </div>
    
    <div class="flex-1 space-y-1">
        @if($label)
            <label class="text-sm font-medium text-gray-700 cursor-pointer">
                {{ $label }}
            </label>
        @endif
        
        @if($error)
            <p class="text-red-600 text-sm font-medium flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ $error }}
            </p>
        @endif
        
        @if($helperText)
            <p class="text-gray-500 text-sm">{{ $helperText }}</p>
        @endif
    </div>
</div>