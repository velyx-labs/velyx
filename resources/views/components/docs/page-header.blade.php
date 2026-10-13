@props([
    'eyebrow' => null,
    'title',
    'description' => null,
])

<header class="mb-10 border-b border-border pb-8">
    @if($eyebrow)
        <p class="mb-3 font-mono text-xs uppercase tracking-[0.14em] text-muted-foreground/60">
            {{ $eyebrow }}
        </p>
    @endif
    <div class="flex flex-wrap items-start justify-between gap-4">
        <h1 class="text-[2rem] font-semibold leading-[1.05] tracking-[-0.03em] text-foreground md:text-[2.5rem]">
            {{ $title }}
        </h1>
        @isset($actions)
            <div class="flex flex-wrap items-center gap-2">{{ $actions }}</div>
        @endisset
    </div>
    @if($description)
        <p class="mt-3 max-w-[60ch] text-base leading-relaxed text-muted-foreground">
            {{ $description }}
        </p>
    @endif
    @isset($meta)
        <div class="mt-4 flex flex-wrap gap-2">{{ $meta }}</div>
    @endisset
</header>
