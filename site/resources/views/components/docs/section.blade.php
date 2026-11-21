@props([
    'id',
    'title',
])

<section id="{{ $id }}" {{ $attributes->class('flex scroll-mt-24 flex-col gap-3.5') }}>
    <h2 class="m-0 font-display text-heading-2 tracking-[-0.02em] text-ink">
        <a href="#{{ $id }}" class="group inline-flex items-center gap-2">
            {{ $title }}
            <span class="text-ink-subtle opacity-0 transition-opacity group-hover:opacity-100" aria-hidden="true">#</span>
        </a>
    </h2>
    {{ $slot }}
</section>
