@if ($collection->lastPage() > 1)
    <nav class="pagination">
        <span class="pagination-meta">Page {{ $collection->currentPage() }} of {{ $collection->lastPage() }}</span>
        <!-- if actual page is not equals 1, and there is more than 5 pages then I show first page button -->
        {{--@if ($collection->currentPage() > 2)@endif--}}
        <a href="{{ $collection->url($collection->url(1)) }}" class="{{ ($collection->currentPage() > 2) ? ' disabled inactive' : '' }}">
            <<
        </a>

        <a href="{{ $collection->url($collection->currentPage()-1) }}"  class="{{ ($collection->currentPage() == 1) ? ' disabled inactive' : '' }}">
            <
        </a>
        <!-- I draw the pages... I show 3 pages back and 3 pages forward -->
        {{--@if($collection->currentPage() > 1)@endif--}}
        @for($i = max($collection->currentPage()-2, 1); $i <= min(max($collection->currentPage()-2, 1)+5,$collection->lastPage()); $i++)
            <a href="{{ $collection->url($i) }}" class="{{ ($collection->currentPage() == $i) ? ' current' : '' }}">{{ $i }}</a>
        @endfor

        {{--@if ($collection->currentPage() != $collection->lastPage())@endif--}}

        <a href="{{ ($collection->currentPage() < $collection->lastPage() ? $collection->url($collection->currentPage()+1) : $collection->url($collection->currentPage())) }}"   class="{{($collection->currentPage() != $collection->lastPage() ? ' disabled inactive' : '')}}">
            >
        </a>

        {{--@if ($collection->currentPage() < $collection->lastPage() - 2)@endif--}}
        <a href="{{ $collection->url($collection->lastPage()) }}"  class="{{($collection->currentPage() < $collection->lastPage() - 2 ? ' disabled inactive' : '')}}">
            >>
        </a>

    </nav>
@endif