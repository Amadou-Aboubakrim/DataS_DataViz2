@if ($paginator->hasPages())
    <div class="pagination-links">
        <ul class="pagination">
            {{-- Page précédente --}}
            @if ($paginator->onFirstPage())
                <li class="disabled">
                    <span class="pagination-prev">Précédent</span>
                </li>
            @else
                <li>
                    <a class="pagination-prev" href="{{ $paginator->previousPageUrl() }}" rel="prev">Précédent</a>
                </li>
            @endif

            {{-- Pagination des pages --}}
            @foreach ($elements as $element)
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active">
                                <span class="pagination-number">{{ $page }}</span>
                            </li>
                        @else
                            <li>
                                <a class="pagination-number" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Page suivante --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a class="pagination-next" href="{{ $paginator->nextPageUrl() }}" rel="next">Suivant</a>
                </li>
            @else
                <li class="disabled">
                    <span class="pagination-next">Suivant</span>
                </li>
            @endif
        </ul>
    </div>
@endif
