@props([
    'eyebrow' => 'Documentation',
    'title',
    'description' => null,
])

<header class="mb-10 border-b border-border pb-8">
    <div class="mb-4">
        <x-ui.badge variant="outline">{{ $eyebrow }}</x-ui.badge>
    </div>
    <h1 class="max-w-4xl text-4xl font-semibold tracking-normal text-foreground md:text-5xl">{{ $title }}</h1>
    @if($description)
        <p class="mt-4 max-w-3xl text-base leading-7 text-muted-foreground md:text-lg">{{ $description }}</p>
    @endif
</header>
