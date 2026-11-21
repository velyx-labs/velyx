<section id="docs" class="scroll-mt-16 border-t border-border">
    <div class="mx-auto flex max-w-[1200px] flex-col items-center gap-[22px] px-4 py-24 text-center sm:px-8">
        <x-reveal><x-landing.heading class="sm:text-[56px] sm:leading-[56px]">Start with one component.</x-landing.heading></x-reveal>
        <x-reveal as="p" :delay="100" class="max-w-[480px] text-body-lg text-ink-muted">Add a button today. Keep it forever. Works in any Laravel 11+ app.</x-reveal>
        <x-reveal :delay="200" class="flex flex-wrap items-center justify-center gap-2.5">
            <x-site.copy-command command="npx velyx add button" tone="dark" />
            <x-site.button variant="outline" href="https://github.com/velyx-labs/velyx#readme">Read the docs</x-site.button>
        </x-reveal>
    </div>
</section>
