{{-- resources/views/components/ui/breadcrumb.blade.php --}}
<nav class="flex" aria-label="Breadcrumb">
    <ol class="flex items-center space-x-2">
        @foreach($items as $index => $item)
            <li class="flex items-center">
                @if($index > 0)
                    <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                @endif
                
                @if($loop->last)
                    <span class="text-sm font-medium text-[#00A3FF]">{{ $item['label'] }}</span>
                @else
                    <a href="{{ $item['url'] }}" class="text-sm font-medium text-gray-500 hover:text-[#00A3FF] transition-colors">
                        {{ $item['label'] }}
                    </a>
                @endif
            </li>
        @endforeach
    </ol>
</nav>