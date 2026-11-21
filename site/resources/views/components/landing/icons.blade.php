@php
    $sets = [
        'lucide' => 'Lucide · default',
        'heroicons' => 'Heroicons',
        'tabler' => 'Tabler',
        'phosphor' => 'Phosphor',
        'svg' => 'Plain SVG',
    ];
    $tag = 'text-[#116329] dark:text-[#7ee787]';
    $attr = 'text-[#0550ae] dark:text-[#79c0ff]';
    $str = 'text-[#0a3069] dark:text-[#a5d6ff]';
    $pun = 'text-[#6e7781] dark:text-[#8b949e]';
@endphp

<section id="icons" class="scroll-mt-16 py-24">
    <div
        x-data="{
            sets: @js(array_keys($sets)),
            set: 'lucide',
            timer: null,
            calm: window.matchMedia('(prefers-reduced-motion: reduce)').matches,
            choose(set, byUser = false) {
                if (byUser) { clearInterval(this.timer); }
                if (set === this.set) { return; }
                this.set = set;
                if (! this.calm) {
                    this.$root.querySelector('[data-icon-value]').animate(
                        [{ opacity: 0, transform: 'translateY(4px)' }, { opacity: 1, transform: 'none' }],
                        { duration: 320, easing: 'cubic-bezier(0.22, 1, 0.36, 1)' },
                    );
                    this.$root.querySelector('[data-icon-glyphs]').animate(
                        [{ opacity: 0.2, transform: 'scale(0.96)' }, { opacity: 1, transform: 'none' }],
                        { duration: 380, easing: 'cubic-bezier(0.22, 1, 0.36, 1)' },
                    );
                }
            },
            cycle() {
                if (this.calm || this.timer) { return; }
                this.timer = setInterval(() => {
                    this.choose(this.sets[(this.sets.indexOf(this.set) + 1) % this.sets.length]);
                }, 2400);
            },
        }"
        x-intersect.once="cycle()"
        class="mx-auto flex max-w-[1200px] flex-wrap items-center gap-14 px-4 sm:px-8"
    >
        <x-reveal class="flex min-w-0 flex-[1_1_360px] flex-col gap-[18px]">
            <x-site.label>Icons</x-site.label>
            <x-landing.heading>Bring your icon set.</x-landing.heading>
            <p class="text-body-lg text-ink-muted">
                Components ask for an icon by name. Pick the library once at init, and every component follows.
                Switch later with one command.
            </p>
            <x-site.terminal class="self-start px-3.5 py-2.5"><span class="text-terminal-muted">$</span> npx velyx icons use <span x-text="set">tabler</span></x-site.terminal>
        </x-reveal>

        <x-reveal :delay="120" class="flex min-w-0 flex-[1_1_560px] flex-col gap-3.5">
            <div role="group" aria-label="Icon library" class="flex flex-wrap gap-2">
                @foreach ($sets as $key => $label)
                    <button
                        type="button"
                        x-on:click="choose('{{ $key }}', true)"
                        x-bind:aria-pressed="set === '{{ $key }}'"
                        x-bind:class="set === '{{ $key }}' ? 'border-transparent bg-primary text-on-primary' : 'border-border bg-surface text-ink hover:bg-surface-subtle'"
                        class="inline-flex h-[34px] items-center rounded-md border px-3.5 text-control font-medium transition-colors duration-300"
                    >{{ $label }}</button>
                @endforeach
            </div>

            <x-site.card class="flex items-center justify-between gap-4 px-5 py-4">
                <div data-icon-glyphs class="flex flex-wrap items-center gap-5 text-ink">
                    <x-landing.icon-glyphs />
                </div>
                <span class="hidden font-mono text-xs text-ink-subtle sm:inline">8 icons · same names</span>
            </x-site.card>

            <x-landing.code-file name="velyx.json" language="JSON"><span class="{{ $pun }}">{</span>
  <span class="{{ $attr }}">"components"</span><span class="{{ $pun }}">:</span> <span class="{{ $str }}">"resources/views/components/ui"</span><span class="{{ $pun }}">,</span>
  <span class="{{ $attr }}">"icons"</span><span class="{{ $pun }}">:</span> <span data-icon-value class="{{ $str }} inline-block">"<span x-text="set">lucide</span>"</span>
<span class="{{ $pun }}">}</span></x-landing.code-file>

            <x-landing.code-file name="dialog.blade.php" language="Blade"><span class="{{ $tag }}">&lt;x-ui.icon</span> <span class="{{ $attr }}">name</span><span class="{{ $pun }}">=</span><span class="{{ $str }}">"x"</span> <span class="{{ $attr }}">class</span><span class="{{ $pun }}">=</span><span class="{{ $str }}">"size-4"</span> <span class="{{ $tag }}">/&gt;</span></x-landing.code-file>
        </x-reveal>
    </div>
</section>
