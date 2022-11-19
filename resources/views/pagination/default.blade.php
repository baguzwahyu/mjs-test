
@if ($paginator->hasPages())
    <nav class="navigation">
       
        @if ($paginator->onFirstPage())
            <a href="javascript:void(0)" class="disabled page-numbers prev">
                <svg class="btn-next">
                    <use xlink:href="#arrow-left"></use>
                </svg>
            </a>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="page-numbers prev">
                <svg class="btn-next">
                    <use xlink:href="#arrow-left"></use>
                </svg>
            </a>
        @endif


      
        @foreach ($elements as $element)
           
            @if (is_string($element))
                <span class="disabled">{{ $element }}</span>
            @endif


           
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a href="javascript:void(0)" class="page-numbers current bg-border-color"><span>{{ $page }}</span></a>
                    @else
                        <a href="{{ $url }}" class="page-numbers bg-border-color"><span>{{ $page }}</span></a>
                    @endif
                @endforeach
            @endif
        @endforeach


        
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="page-numbers next">
                <svg class="btn-next">
                    <use xlink:href="#arrow-right"></use>
                </svg>
            </a>
        @else
            <a href="javascript:void(0)" class="disabled page-numbers next">
                <svg class="btn-next">
                    <use xlink:href="#arrow-right"></use>
                </svg>
            </a>
        @endif
    </nav>
@endif 