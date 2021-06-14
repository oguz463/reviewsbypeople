@if ($paginator->hasPages())
    <nav class="pagination" role="navigation">
        {{-- Previous Page Link --}}
        @if (!$paginator->onFirstPage())
            <a class="pagination__page" href="{{ $paginator->previousPageUrl() }}">&lsaquo;</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="pagination__page">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="pagination__page pagination__page--current">{{ $page }}</span>
                    @else
                        <a class="pagination__page" href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a class="pagination__page pagination__icon pagination__page--next" href="{{ $paginator->nextPageUrl() }}">&rsaquo;</a>
        @endif
    </nav>
@endif
