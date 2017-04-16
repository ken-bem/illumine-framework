@if ($collection->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($collection->onFirstPage())
            <li class="disabled"><span>&laquo;</span></li>
        @else
            <li><a href="{{ $collection->previousPageUrl() }}" rel="prev">&laquo;</a></li>
        @endif
        {{$collection->hasMorePages()}}
        {{-- Next Page Link --}}
        @if ($collection->hasMorePages())
            <li><a href="{{ $collection->nextPageUrl() }}" rel="next">&raquo;</a></li>
        @else
            <li class="disabled"><span>&raquo;</span></li>
        @endif
    </ul>
@endif
