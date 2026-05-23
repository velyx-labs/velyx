@props([
    'eyebrow' => null,
    'title',
    'description' => null,
])

<header class="mb-10 border-b border-border pb-8">
    @if($eyebrow)
        <p class="mb-3 font-mono text-xs uppercase tracking-[0.14em] text-muted-foreground/50">
            {{ $eyebrow }}
        </p>
    @endif
    <h1 class="text-[2rem] font-bold leading-tight tracking-tight text-foreground md:text-[2.5rem]">
        {{ $title }}
    </h1>
    @if($description)
        <p class="mt-3 max-w-[60ch] text-base leading-relaxed text-muted-foreground">
            {{ $description }}
        </p>
    @endif
</header>
