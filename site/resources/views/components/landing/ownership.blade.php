<section class="border-y border-border bg-surface py-24">
    <div class="mx-auto flex max-w-[1200px] flex-wrap items-center gap-14 px-4 sm:px-8">
        <x-reveal class="flex min-w-0 flex-[1_1_360px] flex-col gap-[18px]">
            <x-site.label>Ownership</x-site.label>
            <x-landing.heading>Your code, not a dependency.</x-landing.heading>
            <p class="text-body-lg text-ink-muted">
                Every component is a file in your repository. It shows up in code review, and you can change anything.
                Velyx never overwrites your edits.
            </p>
            <a href="{{ route('docs.guide', 'cli') }}" class="self-start text-[15px] font-semibold underline underline-offset-4 hover:text-ink-muted">How updates work</a>
        </x-reveal>

        <x-reveal :delay="120" class="min-w-0 flex-[1_1_560px]">
            <x-site.terminal
                x-data="{
                    step: 0,
                    start() {
                        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                            this.step = 8;
                            return;
                        }
                        const next = () => {
                            if (this.step >= 8) { return; }
                            this.step++;
                            setTimeout(next, [0, 500, 260, 260, 520, 180, 260, 700][this.step - 1] ?? 220);
                        };
                        setTimeout(next, 450);
                    },
                }"
                x-intersect.once="start()"
                class="overflow-x-auto py-[18px] [&>div]:whitespace-pre"
            >
                <div data-line x-bind:class="step >= 1 && 'is-shown'" class="px-5 pb-2.5"><span class="text-terminal-muted">$</span> npx velyx diff dialog</div>
                <div data-line x-bind:class="step >= 2 && 'is-shown'" class="px-5 pb-2.5 text-terminal-muted">dialog.blade.php · your copy ↔ 3.1.0</div>
                <div data-line x-bind:class="step >= 3 && 'is-shown'" class="px-5 text-terminal-muted">  &lt;div x-data="{ open: false }"</div>
                <div data-line x-bind:class="step >= 4 && 'is-shown'" class="px-5 text-terminal-muted line-through">-      class="fixed inset-0 z-50"</div>
                <div data-line x-bind:class="step >= 5 && 'is-shown animate-flash'" class="bg-white/10 px-5 text-white">+      class="fixed inset-0 z-50 grid place-items-center"</div>
                <div data-line x-bind:class="step >= 6 && 'is-shown'" class="px-5 text-terminal-muted">       x-show="open" x-trap.noscroll="open"&gt;</div>
                <div data-line x-bind:class="step >= 7 && 'is-shown'" class="px-5 pt-3">1 upstream change. Your 3 local edits are kept.</div>
                <div data-line x-bind:class="step >= 8 && 'is-shown'" class="px-5 text-terminal-muted">Apply it with npx velyx update dialog</div>
            </x-site.terminal>
        </x-reveal>
    </div>
</section>
