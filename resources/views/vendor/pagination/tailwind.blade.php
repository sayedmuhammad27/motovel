@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between py-3 px-4 border-t border-[#303137] bg-[#111216] rounded-b-2xl">
        <div class="flex justify-between flex-1 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 text-xs font-medium text-zinc-500 bg-[#191A1F] border border-[#303137] cursor-default rounded-md">
                    Sebelumnya
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-xs font-medium text-[#F4F2EF] bg-[#191A1F] border border-[#303137] rounded-md hover:bg-[#222329]">
                    Sebelumnya
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-xs font-medium text-[#F4F2EF] bg-[#191A1F] border border-[#303137] rounded-md hover:bg-[#222329]">
                    Berikutnya
                </a>
            @else
                <span class="relative inline-flex items-center px-4 py-2 ml-3 text-xs font-medium text-zinc-500 bg-[#191A1F] border border-[#303137] cursor-default rounded-md">
                    Berikutnya
                </span>
            @endif
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-xs text-[#92939A]">
                    Menampilkan
                    <span class="font-medium text-[#F4F2EF]">{{ $paginator->firstItem() }}</span>
                    sampai
                    <span class="font-medium text-[#F4F2EF]">{{ $paginator->lastItem() }}</span>
                    dari total
                    <span class="font-medium text-[#F4F2EF]">{{ $paginator->total() }}</span>
                    data
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex rounded-md shadow-sm space-x-1">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="Sebelumnya">
                            <span class="relative inline-flex items-center px-2 py-1.5 text-xs font-medium text-zinc-600 bg-[#191A1F] border border-[#303137] cursor-default rounded-md" aria-hidden="true">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-2 py-1.5 text-xs font-medium text-[#92939A] bg-[#191A1F] border border-[#303137] rounded-md hover:bg-[#222329] hover:text-[#F4F2EF]" aria-label="Sebelumnya">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span class="relative inline-flex items-center px-3 py-1.5 text-xs font-medium text-[#92939A] bg-[#191A1F] border border-[#303137] cursor-default rounded-md">{{ $element }}</span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span class="relative inline-flex items-center px-3 py-1.5 text-xs font-bold text-white bg-[#C62828] border border-[#C62828] rounded-md">{{ $page }}</span>
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="relative inline-flex items-center px-3 py-1.5 text-xs font-medium text-[#92939A] bg-[#191A1F] border border-[#303137] rounded-md hover:bg-[#222329] hover:text-[#F4F2EF]" aria-label="Halaman {{ $page }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-2 py-1.5 text-xs font-medium text-[#92939A] bg-[#191A1F] border border-[#303137] rounded-md hover:bg-[#222329] hover:text-[#F4F2EF]" aria-label="Berikutnya">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="Berikutnya">
                            <span class="relative inline-flex items-center px-2 py-1.5 text-xs font-medium text-zinc-600 bg-[#191A1F] border border-[#303137] cursor-default rounded-md" aria-hidden="true">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
