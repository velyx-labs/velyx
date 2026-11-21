@props([
    'sections',
    'current',
])

<div class="flex flex-col gap-6">
    @foreach ($sections as $section)
        <nav aria-label="{{ $section['title'] }}" class="flex flex-col gap-0.5">
            <x-site.label class="mb-2 px-2.5">{{ $section['title'] }}</x-site.label>
            @foreach ($section['links'] as $link)
                @php($active = $link['key'] === $current)
                <a
                    href="{{ $link['url'] }}"
                    @if ($active) aria-current="page" @endif
                    @class([
                        'rounded-md px-2.5 py-1.5 text-control transition-colors',
                        'bg-surface-subtle font-semibold text-ink' => $active,
                        'text-ink-muted hover:bg-surface-subtle hover:text-ink' => ! $active,
                    ])
                >{{ $link['title'] }}</a>
            @endforeach
        </nav>
    @endforeach
</div>
