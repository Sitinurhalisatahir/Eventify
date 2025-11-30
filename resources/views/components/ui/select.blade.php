{{-- resources/views/components/ui/select.blade.php --}}
@props([
    'label' => null,
    'error' => null,
    'helperText' => null,
    'required' => false,
    'options' => [],
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
    
    <select 
        {{ $attributes->merge([
            'class' => 'w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#00A3FF] focus:border-[#00A3FF] transition-all duration-300 outline-none bg-white',
            'required' => $required
        ]) }}
    >
        <option value="">Please select</option>
        @foreach($options as $value => $text)
            <option value="{{ $value }}">{{ $text }}</option>
        @endforeach
    </select>
    
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