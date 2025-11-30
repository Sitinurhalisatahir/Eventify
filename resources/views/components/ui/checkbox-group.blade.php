{{-- resources/views/components/ui/checkbox-group.blade.php --}}
@props([
    'label' => null,
    'error' => null,
    'helperText' => null,
    'options' => [],
    'selected' => [],
    'name' => null,
])

<div class="space-y-2">
    @if($label)
        <label class="block text-sm font-semibold text-gray-700">{{ $label }}</label>
    @endif

    <div class="space-y-3">
        @foreach($options as $value => $optionLabel)
            <div class="flex items-center">
                <input 
                    type="checkbox"
                    name="{{ $name }}[]"
                    value="{{ $value }}"
                    {{ in_array($value, $selected) ? 'checked' : '' }}
                    class="w-4 h-4 text-[#00A3FF] bg-white border-gray-300 rounded focus:ring-[#00A3FF] focus:ring-2 transition-all duration-200"
                >
                <label class="ml-3 text-sm font-medium text-gray-700 cursor-pointer">
                    {{ $optionLabel }}
                </label>
            </div>
        @endforeach
    </div>

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