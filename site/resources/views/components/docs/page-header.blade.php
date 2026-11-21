@props([
    'section',
    'sectionUrl' => null,
    'title',
    'description' => null,
])

@aware(['around' => ['previous' => null, 'next' => null]])

<header class="flex flex-col gap-4">
    <nav aria-label="Breadcrumb" class="flex items-center gap-2 text-small text-ink-subtle">
        <a href="{{ route('docs') }}" class="hover:text-ink">Docs</a>
        <span aria-hidden="true">/</span>
        @if ($sectionUrl)
            <a href="{{ $sectionUrl }}" class="hover:text-ink">{{ $section }}</a>
        @else
            <span>{{ $section }}</span>
        @endif
    </nav>
    <div class="flex flex-wrap items-start justify-between gap-4">
        <h1 class="m-0 font-display text-[36px] leading-[38px] font-bold tracking-[-0.025em] sm:text-heading-1">{{ $title }}</h1>
        <x-docs.page-actions :around="$around" class="pt-1.5" />
    </div>
    @if ($description)
        <p class="text-body-lg text-ink-muted">{{ $description }}</p>
    @endif
    {{ $slot }}
</header>
