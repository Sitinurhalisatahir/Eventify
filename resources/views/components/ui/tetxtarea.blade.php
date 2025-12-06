{{-- resources/views/components/ui/textarea.blade.php --}}
@props([
    'label' => null,
    'error' => null,
    'helperText' => null,
    'required' => false,
    'rows' => 4,
])

<div class="space-y-2">
    @if($label)
        <label class="block text-sm font-semibold text-gray-700">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif
    
    <textarea 
        rows="{{ $rows }}"
        {{ $attributes->merge([
            'class' => 'w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#00A3FF] focus:border-[#00A3FF] transition-all duration-300 outline-none resize-vertical',
            'required' => $required
        ]) }}
    >{{ $slot }}</textarea>
    
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