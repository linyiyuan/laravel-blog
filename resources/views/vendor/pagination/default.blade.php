<link rel="stylesheet" href="{{ asset('admin/css/app.css') }}">
@if ($paginator->hasPages())
    <ul class="am-pagination tpl-pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="am-disabled"><a href="javascript:;">&laquo; Prev</a></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo; Prev</a></li>
            <li><a href="{{ $paginator->url(1) }}">首页</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled">{{ $element }}</li>
            @endif
            
            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="am-active"><a href="javascript:;">{{ $page }}</a></li>
                    @else
                        @if($page > $paginator->currentPage() - 4 && $page < $paginator->currentPage() + 4)
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">Next &raquo;</a></li>
            <li><a href="{{ $paginator->url($paginator->lastPage()) }}">尾页</a></li>
        @else
            <li class="disabled"><a href="javascript:;">Next &raquo;</a></li>
        @endif
    </ul>
@endif
