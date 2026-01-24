@if ($paginator->hasPages())
    <nav aria-label="Page navigation">
        <ul class="pagination pagination-sm mb-0">
            {{-- Previous Button --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link" style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">
                        <i class="bi bi-chevron-left"></i> Previous
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">
                        <i class="bi bi-chevron-left"></i> Previous
                    </a>
                </li>
            @endif

            {{-- Pagination Elements with 5-page limit --}}
            @php
                $currentPage = $paginator->currentPage();
                $lastPage = $paginator->lastPage();
                
                // Calculate the start and end of the 5-page window
                $start = max(1, $currentPage - 2);
                $end = min($lastPage, $start + 4);
                
                // Adjust start if we're near the end
                if ($end - $start < 4) {
                    $start = max(1, $end - 4);
                }
            @endphp

            {{-- First Page --}}
            @if ($start > 1)
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url(1) }}" style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">1</a>
                </li>
                @if ($start > 2)
                    <li class="page-item disabled">
                        <span class="page-link" style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">...</span>
                    </li>
                @endif
            @endif

            {{-- Page Numbers (5-page window) --}}
            @for ($page = $start; $page <= $end; $page++)
                @if ($page == $currentPage)
                    <li class="page-item active" aria-current="page">
                        <span class="page-link" style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">{{ $page }}</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->url($page) }}" style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">{{ $page }}</a>
                    </li>
                @endif
            @endfor

            {{-- Last Page --}}
            @if ($end < $lastPage)
                @if ($end < $lastPage - 1)
                    <li class="page-item disabled">
                        <span class="page-link" style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">...</span>
                    </li>
                @endif
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url($lastPage) }}" style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">{{ $lastPage }}</a>
                </li>
            @endif

            {{-- Next Button --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">
                        Next <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link" style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">
                        Next <i class="bi bi-chevron-right"></i>
                    </span>
                </li>
            @endif

            {{-- Jump Button (Jump to next 5 pages) --}}
            @php
                $nextJumpPage = min($lastPage, $currentPage + 5);
                $showJumpButton = $nextJumpPage > $currentPage && $nextJumpPage <= $lastPage;
            @endphp
            
            @if ($showJumpButton)
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url($nextJumpPage) }}" title="Jump to page {{ $nextJumpPage }}" style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">
                        <i class="bi bi-chevron-double-right"></i>
                    </a>
                </li>
            @endif
        </ul>
    </nav>
@endif
