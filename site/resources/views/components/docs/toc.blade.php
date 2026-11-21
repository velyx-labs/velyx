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
</aside>
