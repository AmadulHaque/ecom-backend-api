
<div class="paginationContainer d-flex justify-content-between align-items-center mt-4">
    <div class="d-flex align-items-center">
        
        <p>Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} entries   per page</p>
        <div class="form-group position-relative " style="margin-left: 10px;width: 80px;display:block">
            {{-- <label class="form-label"></label> --}}
            <select  onChange="event.preventDefault();AllScript.pagination('{{ Request::url() }}?{{ http_build_query(array_merge(request()->query(), ['perPage' => '','page' => '1'])) }}'.replace('perPage=', 'perPage='+this.value))" class="custom-select2" style="width:80px">
                <option @selected($paginator->perPage() == 10) value="10">10</option>
                <option @selected($paginator->perPage() == 25) value="25">25</option>
                <option @selected($paginator->perPage() == 50) value="50">50</option>
                <option @selected($paginator->perPage() == 100) value="100">100</option>
                <option @selected($paginator->perPage() == 500) value="500">500</option>
            </select>
        </div>
    </div>
    <nav aria-label="page navigation">
        <ul class="pagination gap-2">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link"><i class="fa-solid fa-chevron-left"></i></span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" onClick="event.preventDefault();AllScript.pagination('{{ $paginator->previousPageUrl() }}')"  href="{{ $paginator->previousPageUrl() }}"><i class="fa-solid fa-chevron-left"></i></a>
                </li>
            @endif
             @php
                $path = $paginator->path();
             @endphp   
            {{-- Page Number Links --}}
            @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
            @if ($paginator->lastPage() <= 12 || 
                $page <= 3 || 
                $page > $paginator->lastPage() - 3 || 
                abs($page - $paginator->currentPage()) <= 1)
                <li class="page-item {{ $page == $paginator->currentPage() ? 'active' : '' }}">
                    @php
                        $query = http_build_query(array_merge(request()->query(), ['page' => $page]));
                    @endphp
                    <a class="page-link" onClick="event.preventDefault();AllScript.pagination('{{ $path }}?{{ $query }}')" href="{{ $path }}?{{ $query }}">{{ $page }}</a>
                </li>
            @elseif ($page == 4 || $page == $paginator->lastPage() - 3)
                <li class="page-item disabled">
                    <span class="page-link">...</span>
                </li>
            @endif
            @endforeach


            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" onClick="event.preventDefault();AllScript.pagination('{{ $paginator->nextPageUrl() }}')" href="{{ $paginator->nextPageUrl() }}"><i class="fa-solid fa-chevron-right"></i></a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link"><i class="fa-solid fa-chevron-right"></i></span>
                </li>
            @endif
        </ul>
    </nav>
</div>
