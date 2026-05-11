@props([
    'name',
    'variant' => null,
    'height' => '220px',
])

@php
    $query = array_filter(['variant' => $variant]);
    $src = route('preview.component', ['component' => $name] + $query);
@endphp

<div class="my-6 overflow-hidden rounded-lg border bg-card">
    <div class="flex items-center justify-between border-b bg-muted/30 px-4 py-2">
        <div class="flex items-center gap-2">
            <x-ui.badge variant="secondary">{{ $name }}</x-ui.badge>
            @if($variant)
                <span class="text-xs text-muted-foreground">{{ $variant }}</span>
            @endif
        </div>
        <x-ui.button href="{{ $src }}" variant="ghost" size="sm" iconRight="external-link">Open</x-ui.button>
    </div>
    <iframe
        src="{{ $src }}"
        title="{{ $name }} preview"
        class="block w-full bg-background"
        style="height: {{ $height }}"
        loading="lazy"
    ></iframe>
</div>
