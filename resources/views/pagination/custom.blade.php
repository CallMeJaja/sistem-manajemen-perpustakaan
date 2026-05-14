@if ($paginator->hasPages())
<nav class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-3">
    <p class="small text-muted mb-0">
        Menampilkan
        <span class="fw-semibold">{{ $paginator->firstItem() }}</span>–<span class="fw-semibold">{{ $paginator->lastItem() }}</span>
        dari <span class="fw-semibold">{{ $paginator->total() }}</span> hasil
    </p>

    <ul class="pagination mb-0" style="font-size: 0.82rem;">
        {{-- Prev --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link" style="font-size: 0.82rem; line-height: 1.4;">&#8249;</span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"
                   style="font-size: 0.82rem; line-height: 1.4;">&#8249;</a>
            </li>
        @endif

        {{-- Pages --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="page-item disabled">
                    <span class="page-link" style="font-size: 0.82rem; line-height: 1.4;">{{ $element }}</span>
                </li>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active">
                            <span class="page-link" style="font-size: 0.82rem; line-height: 1.4;">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $url }}" style="font-size: 0.82rem; line-height: 1.4;">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next"
                   style="font-size: 0.82rem; line-height: 1.4;">&#8250;</a>
            </li>
        @else
            <li class="page-item disabled">
                <span class="page-link" style="font-size: 0.82rem; line-height: 1.4;">&#8250;</span>
            </li>
        @endif
    </ul>
</nav>
@endif
