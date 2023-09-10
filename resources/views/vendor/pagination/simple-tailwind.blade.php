@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-start gap-x-5">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="text-gray-400">
                {!! __('pagination.previous') !!}
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="">
                {!! __('pagination.previous') !!}
            </a>
        @endif

		<div>
			{{ request()->get('page') ?? 1 }}
		</div>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="">
                {!! __('pagination.next') !!}
            </a>
        @else
            <span class="text-gray-400">
                {!! __('pagination.next') !!}
            </span>
        @endif
    </nav>
@endif
