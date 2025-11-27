<nav class="flex items-center space-x-2 text-gray-600 text-sm">
    @foreach ($items as $item)
        @if (!$loop->last)
            <a href="{{ $item['url'] }}" class="hover:text-blue-600 font-medium">
                {{ $item['label'] }}
            </a>
            <span>/</span>
        @else
            <span class="text-gray-900 font-semibold">
                {{ $item['label'] }}
            </span>
        @endif
    @endforeach
</nav>
