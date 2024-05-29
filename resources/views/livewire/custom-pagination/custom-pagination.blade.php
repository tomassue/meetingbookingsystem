<style>
    /* Custom Pagination */
    .active>.page-link,
    .page-link.active {
        background-color: #0a927c !important;
        border-color: #0a927c !important;
    }

    .pagination {
        --bs-pagination-color: #0a927c !important;
        --bs-pagination-hover-color: #444 !important;
        --bs-pagination-focus-color: #0a927c !important;
    }
</style>

<div class="col mt-4">
    @if ($paginator->hasPages())
    <nav role="navigation" aria-label="Page navigation example">
        <ul class="pagination justify-content-end">
            <!-- Previous -->
            @if ($paginator->onFirstPage())
            <li class="page-item disabled"><a class="page-link">Previous</a></li>
            @else
            <li class="page-item"><button type="button" class="page-link" wire:click="previousPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled" rel="prev">Previous</b></li>
            @endif
            <!-- Previous end -->

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
            <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
            @foreach ($element as $page => $url)
            @if ($page == $paginator->currentPage())
            <li class="page-item active" wire:key="paginator-{{ $paginator->getPageName() }}-page-{{ $page }}" aria-current="page"><span class="page-link">{{ $page }}</span></li>
            @else
            <li class="page-item" wire:key="paginator-{{ $paginator->getPageName() }}-page-{{ $page }}"><button type="button" class="page-link" wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')">{{ $page }}</button></li>
            @endif
            @endforeach
            @endif
            @endforeach

            <!-- Next -->
            @if ($paginator->onLastPage())
            <li class="page-item disabled"><a class="page-link">Next</a></li>
            @else
            <li class="page-item"><button type="button" class="page-link" wire:click="nextPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled" rel="next">Next</button></li>
            @endif
            <!-- Next end -->
        </ul>
    </nav>
    @endif
</div>