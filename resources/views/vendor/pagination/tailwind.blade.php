@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between mt-6">
        {{-- Mobile View --}}
        <div class="flex justify-between flex-1 sm:hidden">
            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <span class="px-4 py-2 text-sm text-gray-400 bg-white border border-gray-200 rounded-md cursor-default">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <button wire:click="previousPage" class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-md hover:text-teal-600 hover:bg-teal-50 transition">
                    {!! __('pagination.previous') !!}
                </button>
            @endif

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <button wire:click="nextPage" class="ml-3 px-4 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-md hover:text-teal-600 hover:bg-teal-50 transition">
                    {!! __('pagination.next') !!}
                </button>
            @else
                <span class="ml-3 px-4 py-2 text-sm text-gray-400 bg-white border border-gray-200 rounded-md cursor-default">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>

        {{-- Desktop View --}}
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            {{-- Info --}}
            <div>
                <p class="text-sm text-gray-600">
                    {!! __('Showing') !!}
                    @if ($paginator->firstItem())
                        <span class="font-medium">{{ $paginator->firstItem() }}</span>
                        {!! __('to') !!}
                        <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    {!! __('of') !!}
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    {!! __('results') !!}
                </p>
            </div>

            {{-- Buttons --}}
            <div>
                <span class="relative z-0 inline-flex shadow-sm rounded-md">
                    {{-- Prev Button --}}
                    @if ($paginator->onFirstPage())
                        <span class="px-3 py-2 text-sm text-gray-300 bg-white border border-gray-200 rounded-l-md cursor-not-allowed">
                            ‹
                        </span>
                    @else
                        <button wire:click="previousPage" class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-l-md hover:text-teal-600 hover:bg-teal-50 transition" rel="prev">
                            ‹
                        </button>
                    @endif

                    {{-- Page Links --}}
                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <span class="px-3 py-2 text-sm text-gray-400 bg-white border border-gray-200">{{ $element }}</span>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span class="px-3 py-2 text-sm text-white bg-teal-600 border border-teal-600 cursor-default">{{ $page }}</span>
                                @else
                                    <button wire:click="gotoPage({{ $page }})" class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-200 hover:text-teal-600 hover:bg-teal-50 transition" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                        {{ $page }}
                                    </button>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Button --}}
                    @if ($paginator->hasMorePages())
                        <button wire:click="nextPage" class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-r-md hover:text-teal-600 hover:bg-teal-50 transition" rel="next">
                            ›
                        </button>
                    @else
                        <span class="px-3 py-2 text-sm text-gray-300 bg-white border border-gray-200 rounded-r-md cursor-not-allowed">
                            ›
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
