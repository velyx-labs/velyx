<section aria-label="Built for" class="border-y border-border bg-surface">
    <div class="mx-auto flex max-w-[1200px] flex-wrap items-center justify-between gap-6 px-4 py-[26px] sm:px-8">
        <x-reveal><x-site.label>Built for the stack you already use</x-site.label></x-reveal>
        <ul class="flex flex-wrap items-center gap-9 text-[15px] font-semibold text-ink-muted">
            <x-reveal as="li" :delay="80" class="group flex items-center gap-2"><x-icons.laravel class="h-[22px] w-auto opacity-75 grayscale transition duration-300 group-hover:opacity-100 group-hover:grayscale-0" />Laravel</x-reveal>
            <x-reveal as="li" :delay="160" class="group flex items-center gap-2"><x-icons.livewire class="h-6 w-auto opacity-75 grayscale transition duration-300 group-hover:opacity-100 group-hover:grayscale-0" />Livewire</x-reveal>
            <x-reveal as="li" :delay="240" class="group flex items-center gap-2"><x-icons.alpinejs class="h-[26px] w-auto opacity-75 grayscale transition duration-300 group-hover:opacity-100 group-hover:grayscale-0 dark:invert" />Alpine.js</x-reveal>
            <x-reveal as="li" :delay="320" class="group flex items-center gap-2"><x-icons.tailwind class="h-[17px] w-auto opacity-75 grayscale transition duration-300 group-hover:opacity-100 group-hover:grayscale-0" />Tailwind CSS</x-reveal>
        </ul>
    </div>
</section>
