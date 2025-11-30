{{-- resources/views/components/ui/pagination.blade.php --}}
@if ($paginator->hasPages())
    <nav class="flex items-center justify-between border-t border-gray-200 px-4 sm:px-0">
        <div class="flex flex-1 w-0">
            <!-- Previous Page Link -->
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center border-t-2 border-transparent pt-4 pr-1 text-sm font-medium text-gray-400">
                    <i class="fas fa-chevron-left mr-2"></i>
                    Previous
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="inline-flex items-center border-t-2 border-transparent pt-4 pr-1 text-sm font-medium text-gray-500 hover:text-[#00A3FF] hover:border-[#00A3FF] transition-colors">
                    <i class="fas fa-chevron-left mr-2"></i>
                    Previous
                </a>
            @endif
        </div>

        <div class="hidden md:flex">
            <!-- Page Numbers -->
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="inline-flex items-center border-t-2 border-transparent px-4 pt-4 text-sm font-medium text-gray-400">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="inline-flex items-center border-t-2 border-[#00A3FF] px-4 pt-4 text-sm font-medium text-[#00A3FF]">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="inline-flex items-center border-t-2 border-transparent px-4 pt-4 text-sm font-medium text-gray-500 hover:text-[#00A3FF] hover:border-[#00A3FF] transition-colors">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        <div class="flex flex-1 justify-end w-0">
            <!-- Next Page Link -->
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="inline-flex items-center border-t-2 border-transparent pt-4 pl-1 text-sm font-medium text-gray-500 hover:text-[#00A3FF] hover:border-[#00A3FF] transition-colors">
                    Next
                    <i class="fas fa-chevron-right ml-2"></i>
                </a>
            @else
                <span class="inline-flex items-center border-t-2 border-transparent pt-4 pl-1 text-sm font-medium text-gray-400">
                    Next
                    <i class="fas fa-chevron-right ml-2"></i>
                </span>
            @endif
        </div>
    </nav>
@endif