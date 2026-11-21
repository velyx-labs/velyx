<section id="components" aria-label="Component examples" class="pb-[88px]">
    <div class="mx-auto grid max-w-[1200px] grid-cols-1 items-start gap-4 px-4 sm:px-8 md:grid-cols-2 lg:grid-cols-3">

        <div class="flex min-w-0 flex-col gap-4">
            <x-reveal :delay="0">
                <x-site.card class="flex flex-col gap-4 p-[22px]">
                    <div class="flex flex-col gap-1">
                        <span class="text-body font-semibold">Create project</span>
                        <span class="text-small text-ink-subtle">Deploy a new Laravel app in one click.</span>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label for="cp-name" class="text-small font-medium">Name</label>
                        <input id="cp-name" type="text" value="billing-api" class="h-[38px] w-full rounded-md border border-border-strong bg-surface px-3 text-control text-ink">
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label for="cp-stack" class="text-small font-medium">Stack</label>
                        <button id="cp-stack" type="button" class="flex h-[38px] w-full items-center justify-between rounded-md border border-border-strong bg-surface px-3 text-left text-control text-ink">
                            Livewire + Alpine
                            <x-tabler-chevron-down class="size-3.5 text-ink-subtle" aria-hidden="true" />
                        </button>
                    </div>
                    <div class="flex justify-between gap-2">
                        <x-site.button variant="outline" class="h-9">Cancel</x-site.button>
                        <x-site.button class="h-9">Create</x-site.button>
                    </div>
                </x-site.card>
            </x-reveal>

            <x-reveal :delay="110">
                <x-site.card class="flex flex-col gap-3.5 p-[22px]">
                    <x-site.label>Badge</x-site.label>
                    <div class="flex flex-wrap gap-1.5 text-xs font-semibold">
                        <span class="rounded-sm bg-primary px-[9px] py-[3px] text-on-primary">Default</span>
                        <span class="rounded-sm bg-surface-subtle px-[9px] py-[3px] text-ink">Secondary</span>
                        <span class="rounded-sm border border-border px-[9px] py-[3px]">Outline</span>
                        <span class="rounded-sm border border-success px-[9px] py-[3px] text-success">✓ Installed</span>
                        <span class="rounded-sm border border-danger px-[9px] py-[3px] text-danger">✕ Failed</span>
                    </div>
                    <x-site.label class="mt-1.5">Button</x-site.label>
                    <div class="flex flex-wrap gap-1.5">
                        <x-site.button size="sm">Primary</x-site.button>
                        <x-site.button variant="outline" size="sm">Outline</x-site.button>
                        <x-site.button variant="ghost" size="sm">Ghost</x-site.button>
                        <x-site.button variant="danger" size="sm">Delete</x-site.button>
                    </div>
                </x-site.card>
            </x-reveal>
        </div>

        <div class="flex min-w-0 flex-col gap-4">
            <x-reveal :delay="90">
                <x-site.card x-data="{ tab: 'notifications', alerts: true, digest: false }" class="flex flex-col gap-4 p-[22px]">
                    <div role="tablist" aria-label="Settings" class="flex gap-1 rounded-md bg-surface-subtle p-1">
                        @foreach (['notifications' => 'Notifications', 'security' => 'Security'] as $key => $label)
                            <button
                                type="button"
                                role="tab"
                                x-on:click="tab = '{{ $key }}'"
                                x-bind:aria-selected="tab === '{{ $key }}'"
                                x-bind:class="tab === '{{ $key }}' ? 'bg-surface font-semibold text-ink shadow-sm' : 'text-ink-muted'"
                                class="h-[30px] flex-1 rounded-sm text-small"
                            >{{ $label }}</button>
                        @endforeach
                    </div>

                    <div x-show="tab === 'notifications'" class="flex flex-col gap-4">
                        @foreach (['alerts' => ['Deploy alerts', 'Email me when a deploy fails.'], 'digest' => ['Weekly digest', 'A summary every Monday.']] as $key => [$title, $hint])
                            @if (! $loop->first)
                                <div class="h-px bg-border"></div>
                            @endif
                            <div class="flex items-center justify-between gap-4">
                                <div class="flex flex-col gap-0.5">
                                    <span class="text-control font-medium">{{ $title }}</span>
                                    <span class="text-small text-ink-subtle">{{ $hint }}</span>
                                </div>
                                <button
                                    type="button"
                                    role="switch"
                                    aria-label="{{ $title }}"
                                    x-on:click="{{ $key }} = ! {{ $key }}"
                                    x-bind:aria-checked="{{ $key }}"
                                    x-bind:class="{{ $key }} ? 'bg-primary' : 'bg-border'"
                                    class="relative h-[22px] w-[38px] shrink-0 rounded-full transition-colors"
                                >
                                    <span
                                        x-bind:class="{{ $key }} ? 'translate-x-4' : 'translate-x-0'"
                                        class="absolute top-[3px] left-[3px] size-4 rounded-full bg-surface shadow-sm transition-transform dark:bg-canvas"
                                    ></span>
                                </button>
                            </div>
                        @endforeach
                    </div>

                    <div x-show="tab === 'security'" x-cloak class="flex flex-col gap-1">
                        <span class="text-control font-medium">Two-factor authentication</span>
                        <span class="text-small text-ink-subtle">Require a code from your authenticator app at sign in.</span>
                    </div>
                </x-site.card>
            </x-reveal>

            <x-reveal :delay="200">
                <x-site.card class="flex flex-col gap-2.5 p-[22px] shadow-overlay">
                    <span class="text-body font-semibold">Delete this project?</span>
                    <span class="text-control leading-[21px] text-ink-muted">billing-api and its deployments will be removed. This cannot be undone.</span>
                    <div class="mt-1.5 flex justify-end gap-2">
                        <x-site.button variant="outline" class="h-9">Cancel</x-site.button>
                        <x-site.button variant="danger" class="h-9">Delete project</x-site.button>
                    </div>
                </x-site.card>
            </x-reveal>

            <x-reveal :delay="310">
                <x-site.card class="flex items-start gap-3 px-4 py-3.5 shadow-overlay">
                    <x-tabler-circle-check class="mt-px size-[18px] shrink-0 text-success" aria-hidden="true" />
                    <div class="flex grow flex-col gap-0.5">
                        <span class="text-control font-semibold">Changes saved</span>
                        <span class="text-small text-ink-muted">Your notification settings are up to date.</span>
                    </div>
                    <x-site.button variant="outline" class="h-7 px-2.5 text-xs">Undo</x-site.button>
                </x-site.card>
            </x-reveal>
        </div>

        <div class="flex min-w-0 flex-col gap-4">
            <x-reveal :delay="180">
                <x-site.terminal
                    x-data="{
                        command: 'npx velyx add dialog',
                        typed: '',
                        step: 0,
                        start() {
                            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                                this.typed = this.command;
                                this.step = 8;
                                return;
                            }
                            let i = 0;
                            const type = () => {
                                this.typed = this.command.slice(0, ++i);
                                if (i < this.command.length) {
                                    setTimeout(type, 40 + Math.random() * 45);
                                } else {
                                    setTimeout(() => this.next(), 420);
                                }
                            };
                            setTimeout(type, 500);
                        },
                        next() {
                            if (this.step >= 8) { return; }
                            this.step++;
                            setTimeout(() => this.next(), this.step === 1 ? 650 : 200);
                        },
                    }"
                    x-intersect.once="start()"
                    class="min-h-[248px] px-[18px] pt-4 pb-[18px]"
                >
                    <div class="mb-2.5 text-xs text-terminal-muted">~/billing-api</div>
                    <div><span class="text-terminal-muted">$</span> <span x-text="typed">npx velyx add dialog</span><span x-show="step === 0" class="ml-px inline-block h-4 w-2 animate-blink bg-on-terminal align-[-3px]"></span></div>
                    <div data-line x-bind:class="step >= 1 && 'is-shown'" class="text-terminal-muted">&nbsp; Resolving dialog@3.0.0, button@3.0.0</div>
                    <div data-line x-bind:class="step >= 2 && 'is-shown'"><span class="text-terminal-muted">&nbsp; +</span> components/ui/dialog.blade.php</div>
                    <div data-line x-bind:class="step >= 3 && 'is-shown'"><span class="text-terminal-muted">&nbsp; +</span> components/ui/button.blade.php</div>
                    <div data-line x-bind:class="step >= 4 && 'is-shown'"><span class="text-[#4ade80]">&nbsp; ✓</span> <span class="text-terminal-muted">blade-lucide-icons installed</span></div>
                    <div data-line x-bind:class="step >= 5 && 'is-shown'" class="mt-1.5">Added 2 components.</div>
                    <div data-line x-bind:class="step >= 6 && 'is-shown'" class="text-terminal-muted">Review the diff, then commit.</div>
                    <div data-line x-bind:class="step >= 7 && 'is-shown'"><span class="text-terminal-muted">$</span> <span class="inline-block h-4 w-2 animate-blink bg-on-terminal align-[-3px]"></span></div>
                </x-site.terminal>
            </x-reveal>

            <x-reveal :delay="290">
                <x-site.card class="overflow-hidden">
                    <div class="flex items-center gap-2 border-b border-border px-3.5 py-3 text-control text-ink-subtle">
                        <x-tabler-search class="size-[15px]" aria-hidden="true" />
                        Type a command…
                    </div>
                    <div class="flex flex-col p-1.5 text-control">
                        <x-site.label class="px-2.5 pt-2 pb-1">Components</x-site.label>
                        <span class="flex justify-between rounded-sm bg-surface-subtle px-2.5 py-2">Dialog <span class="font-mono text-[11px] text-ink-subtle">↵</span></span>
                        <span class="px-2.5 py-2">Data table</span>
                        <span class="px-2.5 py-2">Date picker</span>
                    </div>
                </x-site.card>
            </x-reveal>

            <x-reveal :delay="400">
                <x-site.card class="flex items-center justify-between gap-3 px-5 py-[18px]">
                    <div class="flex">
                        <span class="grid size-8 place-items-center rounded-full border-2 border-surface bg-primary text-xs font-semibold text-on-primary">JK</span>
                        <span class="-ml-2 grid size-8 place-items-center rounded-full border-2 border-surface bg-ink-muted text-xs font-semibold text-on-primary">AM</span>
                        <span class="-ml-2 grid size-8 place-items-center rounded-full border-2 border-surface bg-border text-xs font-semibold text-ink">+3</span>
                    </div>
                    <span class="text-small text-ink-subtle">Open with <x-site.kbd>⌘</x-site.kbd> <x-site.kbd>K</x-site.kbd></span>
                </x-site.card>
            </x-reveal>
        </div>

    </div>
</section>
