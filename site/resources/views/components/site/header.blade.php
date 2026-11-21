@php
    $links = [
        'Docs' => '#docs',
        'Components' => '#components',
        'CLI' => '#cli',
        'Icons' => '#icons',
        'Changelog' => 'https://github.com/velyx-labs/velyx/releases',
    ];
@endphp

<header x-data="{ menu: false }" class="sticky top-0 z-40 border-b border-border bg-canvas/90 backdrop-blur">
    <div class="mx-auto flex h-[60px] max-w-[1200px] items-center gap-6 px-4 sm:px-8">
        <a href="{{ route('home') }}" aria-label="Velyx home">
            <x-logo />
        </a>

        <nav aria-label="Main" class="hidden items-center gap-[22px] text-control text-ink-muted md:flex">
            @foreach ($links as $label => $href)
                <a href="{{ $href }}" class="hover:text-ink">{{ $label }}</a>
            @endforeach
        </nav>

        <div class="ml-auto flex items-center gap-1.5">
            <x-site.button variant="ghost" size="sm" href="https://github.com/velyx-labs/velyx" class="px-2.5" aria-label="Velyx on GitHub">
                <x-icons.github class="size-4" />
                <span class="hidden text-small sm:inline">GitHub</span>
            </x-site.button>
            <x-site.button variant="ghost" size="sm" href="https://buymeacoffee.com/jiordiviera" class="px-2.5" aria-label="Support Velyx on Buy Me a Coffee">
                <x-icons.buy-me-a-coffee class="h-[17px] w-auto" />
                <span class="hidden text-small sm:inline">Sponsor</span>
            </x-site.button>
            <x-site.theme-toggle />
            <button
                type="button"
                x-on:click="menu = ! menu"
                x-bind:aria-expanded="menu"
                aria-controls="mobile-menu"
                class="inline-flex size-[34px] items-center justify-center rounded-md text-ink hover:bg-surface-subtle md:hidden"
            >
                <x-tabler-menu-2 class="size-[18px]" x-show="! menu" aria-hidden="true" />
                <x-tabler-x class="size-[18px]" x-show="menu" x-cloak aria-hidden="true" />
                <span class="sr-only">Menu</span>
            </button>
        </div>
    </div>

    <nav
        id="mobile-menu"
        aria-label="Mobile"
        x-show="menu"
        x-cloak
        x-on:click.outside="menu = false"
        x-on:keydown.escape.window="menu = false"
        class="border-t border-border bg-canvas px-4 py-3 md:hidden"
    >
        @foreach ($links as $label => $href)
            <a href="{{ $href }}" x-on:click="menu = false" class="block rounded-md px-3 py-2.5 text-body text-ink hover:bg-surface-subtle">{{ $label }}</a>
        @endforeach
    </nav>
</header>
