@php
    $steps = [
        ['01', 'Initialize', 'npx velyx init', 'Detects Laravel, Livewire and Tailwind, asks for your icon set and writes <code>velyx.json</code>.'],
        ['02', 'Add', 'npx velyx add dialog', 'Copies the Blade file into <code>components/ui</code>, with the components and packages it needs.'],
        ['03', 'Own it', 'npx velyx diff dialog', 'Edit the files freely. When a new version ships, see what changed and take only what you want.'],
    ];
@endphp

<section id="cli" class="scroll-mt-16 py-24">
    <div class="mx-auto flex max-w-[1200px] flex-col gap-11 px-4 sm:px-8">
        <x-reveal class="flex max-w-[640px] flex-col gap-3">
            <x-site.label>How it works</x-site.label>
            <x-landing.heading>Three commands. Then it is your code.</x-landing.heading>
        </x-reveal>

        <ol class="grid grid-cols-1 gap-4 md:grid-cols-3">
            @foreach ($steps as [$number, $title, $command, $description])
                <x-reveal as="li" :delay="$loop->index * 120">
                    <x-site.card class="group flex h-full flex-col gap-3.5 p-6 transition-colors duration-300 hover:border-border-strong">
                        <span class="font-mono text-xs text-ink-subtle transition-colors duration-300 group-hover:text-ink">{{ $number }}</span>
                        <span class="text-body-lg font-semibold">{{ $title }}</span>
                        <x-site.terminal class="px-3.5 py-2.5"><span class="text-terminal-muted">$</span> {{ $command }}</x-site.terminal>
                        <p class="text-[15px] leading-6 text-ink-muted [&_code]:rounded-sm [&_code]:bg-surface-subtle [&_code]:px-[5px] [&_code]:py-px [&_code]:font-mono [&_code]:text-[13px] [&_code]:text-ink">{!! $description !!}</p>
                    </x-site.card>
                </x-reveal>
            @endforeach
        </ol>
    </div>
</section>
