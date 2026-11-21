@php
    $headline = ['Laravel', 'components', 'you', 'own,', 'line', 'by', 'line.'];
@endphp

<section id="top" class="pt-[88px] pb-14">
    <div class="mx-auto flex max-w-[1200px] flex-col items-center gap-6 px-4 text-center sm:px-8">
        <x-reveal as="a" href="https://github.com/velyx-labs/velyx/releases" class="group inline-flex h-7 items-center gap-2 rounded-full border border-border bg-surface px-3 text-small font-medium text-ink hover:bg-surface-subtle">
            <span class="rounded-full bg-primary px-1.5 py-px font-mono text-[11px] text-on-primary">3.0</span>
            Go CLI, icon sets and Laravel 10+
            <x-tabler-arrow-right class="size-3.5 transition-transform duration-300 ease-out-quint group-hover:translate-x-0.5" aria-hidden="true" />
        </x-reveal>

        <h1 class="m-0 max-w-[820px] font-display text-[44px] leading-[44px] font-bold tracking-[-0.03em] text-balance sm:text-[72px] sm:leading-[68px]">
            @foreach ($headline as $word)
                <x-reveal as="span" :delay="80 + $loop->index * 55" class="inline-block [--reveal-distance:0.4em]">{{ $word }}</x-reveal>
            @endforeach
        </h1>

        <x-reveal as="p" :delay="520" class="max-w-[580px] text-body-lg text-ink-muted">
            Accessible Blade, Livewire and Alpine components you copy into your app with one command.
            Read them, change them, ship them. There is no package to update.
        </x-reveal>

        <x-reveal :delay="620" class="flex flex-wrap justify-center gap-2.5">
            <x-site.button :href="route('docs.guide', 'installation')">Get started</x-site.button>
            <x-site.button variant="outline" :href="route('docs.components')">Browse components</x-site.button>
        </x-reveal>

        <x-reveal :delay="720">
            <x-site.copy-command command="npx velyx init" />
        </x-reveal>
    </div>
</section>
