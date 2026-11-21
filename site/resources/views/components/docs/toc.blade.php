@props([
    'items',
])

<aside
    aria-label="On this page"
    x-data="{
        active: @js(array_key_first($items)),
        init() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) { this.active = entry.target.id; }
                });
            }, { rootMargin: '-80px 0px -70% 0px' });
            @js(array_keys($items)).forEach((id) => {
                const el = document.getElementById(id);
                if (el) { observer.observe(el); }
            });
        },
    }"
    class="sticky top-[84px] hidden w-[200px] shrink-0 flex-col gap-2.5 text-small xl:flex"
>
    <x-site.label>On this page</x-site.label>
    @foreach ($items as $id => $label)
        <a
            href="#{{ $id }}"
            x-bind:class="active === @js($id) ? 'text-ink font-medium' : 'text-ink-muted'"
            class="text-ink-muted transition-colors hover:text-ink"
        >{{ $label }}</a>
    @endforeach
    <div class="my-2 h-px bg-border"></div>
    <a href="{{ config('docs.repository') }}" class="inline-flex items-center gap-1.5 text-ink-muted hover:text-ink">
        <x-icons.github class="size-3.5" />
        Edit on GitHub
    </a>

    <a href="https://buymeacoffee.com/jiordiviera" class="group mt-4 flex flex-col gap-2 rounded-lg border border-border bg-surface p-3.5 transition-colors hover:border-border-strong">
        <span class="flex items-center gap-2 font-semibold text-ink">
            <x-icons.buy-me-a-coffee class="h-4 w-auto" />
            Support Velyx
        </span>
        <span class="text-ink-muted">Velyx is free and MIT licensed. A coffee keeps new components coming.</span>
        <span class="inline-flex items-center gap-1 font-medium text-ink">
            Buy me a coffee
            <x-tabler-arrow-right class="size-3.5 transition-transform group-hover:translate-x-0.5" aria-hidden="true" />
        </span>
    </a>
</aside>
