{{-- resources/views/components/ui/tabs.blade.php --}}
@props([
    'tabs' => [],
    'activeTab' => 0,
])

<div class="border-b border-gray-200">
    <nav class="-mb-px flex space-x-8">
        @foreach($tabs as $index => $tab)
            <button
                @click="activeTab = {{ $index }}"
                :class="{
                    'border-[#00A3FF] text-[#00A3FF]': activeTab === {{ $index }},
                    'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== {{ $index }}
                }"
                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200"
            >
                <i class="{{ $tab['icon'] ?? 'fas fa-circle' }} mr-2"></i>
                {{ $tab['label'] }}
            </button>
        @endforeach
    </nav>
</div>

<!-- Tab Panels -->
<div class="mt-4">
    @foreach($tabs as $index => $tab)
        <div x-show="activeTab === {{ $index }}">
            {{ ${'tab' . $index} ?? '' }}
        </div>
    @endforeach
</div>