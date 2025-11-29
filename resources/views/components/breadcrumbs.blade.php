<nav aria-label="breadcrumb" 
     style="--bs-breadcrumb-divider:'>'; padding:10px 14px; background:#f8f9fa; border-radius:6px;">

    <ol style="list-style:none; display:flex; gap:6px; margin:0; padding:0; align-items:center;">

        @foreach ($items as $item)
            @if (!$loop->last)

                <li style="font-weight:500; display:flex; align-items:center;">
                    <a href="{{ $item['url'] }}" 
                       style="text-decoration:none; color:#0d6efd; font-size: 14px;">
                        {{ $item['label'] }}
                    </a>
                    <span style="margin: 0 6px; color:#6c757d;">></span>
                </li>

            @else

                <li style="font-weight:600; color:#6c757d; font-size: 14px;">
                    {{ $item['label'] }}
                </li>

            @endif
        @endforeach

    </ol>
</nav>
