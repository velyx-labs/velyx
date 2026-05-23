<?php

use App\Services\ComponentService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

new class extends Component
{
    public array $components = [];
    public int $stars = 0;

    public function mount(ComponentService $componentService): void
    {
        $this->components = $componentService->getAllComponents();
        $this->stars = Cache::remember('github_stars_velyx', 3600, function () {
            $response = Http::withHeaders(['Accept' => 'application/vnd.github+json'])
                ->timeout(5)
                ->get('https://api.github.com/repos/velyx-labs/registry');

            return $response->successful() ? (int) $response->json('stargazers_count', 0) : 0;
        });
    }
};
?>

<div>

    {{-- ─── HERO ──────────────────────────────────────────────────────────── --}}
    <section class="relative min-h-screen flex flex-col justify-center overflow-hidden px-6 lg:px-12 xl:px-24">

        {{-- Ambient glow — upper right, barely visible --}}
        <div class="pointer-events-none absolute -top-40 right-0 h-[600px] w-[600px] rounded-full opacity-[0.06] dark:opacity-[0.08]"
             style="background: radial-gradient(circle, oklch(0.85 0.12 80) 0%, transparent 70%);"></div>

        <div class="relative z-10 w-full max-w-7xl mx-auto">
            <div class="grid lg:grid-cols-[1fr_480px] gap-16 xl:gap-24 items-center">

                {{-- ── Left: copy ── --}}
                <div class="space-y-9">

                    {{-- Eyebrow --}}
                    <div class="flex items-center gap-3">
                        <span class="block h-px w-6 bg-foreground/25"></span>
                        <span class="font-mono text-xs uppercase tracking-[0.15em] text-muted-foreground">
                            Laravel · Blade · Livewire
                        </span>
                    </div>

                    {{-- Headline --}}
                    <h1 class="text-[clamp(3.25rem,8vw,6.5rem)] font-bold leading-[0.88] tracking-tight text-foreground">
                        Blade&nbsp;UI<br>
                        <span class="font-light text-muted-foreground">you&nbsp;own.</span>
                    </h1>

                    {{-- Body --}}
                    <p class="max-w-[44ch] text-lg leading-relaxed text-muted-foreground">
                        Production-ready components for Laravel. Copy them into your codebase, adapt them freely.
                        No vendor lock-in, no runtime surprises.
                    </p>

                    {{-- CTAs --}}
                    <div class="flex flex-wrap items-center gap-3">
                        <x-ui.button href="{{ route('docs.page', 'installation') }}" wire:navigate size="lg" iconRight="arrow-right">
                            Get started
                        </x-ui.button>
                        <x-ui.button href="{{ route('docs.page', 'components') }}" wire:navigate variant="outline" size="lg">
                            Browse {{ count($this->components) }} components
                        </x-ui.button>
                    </div>

                    {{-- GitHub stars --}}
                    <a
                        href="https://github.com/velyx-labs/registry"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center gap-2 text-sm text-muted-foreground/70 transition-colors hover:text-muted-foreground"
                    >
                        <x-lucide-star class="size-3.5" />
                        @if($stars > 0)
                            <strong class="font-semibold text-foreground">{{ number_format($stars) }}</strong> stars on GitHub
                        @else
                            Star us on GitHub
                        @endif
                    </a>
                </div>

                {{-- ── Right: terminal ── --}}
                <div class="hidden lg:block">
                    <div class="rounded-xl overflow-hidden border border-border bg-card shadow-2xl">

                        {{-- Terminal chrome --}}
                        <div class="flex items-center gap-2 px-4 py-3 border-b border-border bg-muted/30">
                            <span class="size-2.5 rounded-full bg-border"></span>
                            <span class="size-2.5 rounded-full bg-border"></span>
                            <span class="size-2.5 rounded-full bg-border"></span>
                            <span class="ml-3 font-mono text-xs text-muted-foreground/60">zsh</span>
                        </div>

                        {{-- Terminal output --}}
                        <div class="p-5 font-mono text-sm leading-relaxed space-y-4">

                            <div class="space-y-1">
                                <div class="flex gap-2">
                                    <span class="text-muted-foreground select-none">$</span>
                                    <span class="text-foreground">npx velyx@latest init</span>
                                </div>
                                <div class="pl-5 space-y-0.5 text-xs">
                                    <div class="text-green-500 dark:text-green-400">✓ Detected Laravel project</div>
                                    <div class="text-green-500 dark:text-green-400">✓ Configuration saved to velyx.json</div>
                                </div>
                            </div>

                            <div class="space-y-1">
                                <div class="flex gap-2">
                                    <span class="text-muted-foreground select-none">$</span>
                                    <span class="text-foreground">npx velyx@latest add button field input</span>
                                </div>
                                <div class="pl-5 space-y-0.5 text-xs">
                                    <div class="text-green-500 dark:text-green-400">✓ button.blade.php</div>
                                    <div class="text-green-500 dark:text-green-400">✓ field/index.blade.php</div>
                                    <div class="text-green-500 dark:text-green-400">✓ input/index.blade.php</div>
                                    <div class="text-muted-foreground/60 pt-0.5">3 components copied. They're yours now.</div>
                                </div>
                            </div>

                            <div class="flex gap-2">
                                <span class="text-muted-foreground select-none">$</span>
                                <span class="inline-block w-1.5 h-4 bg-foreground/70 animate-pulse"></span>
                            </div>

                        </div>
                    </div>

                    {{-- Support nudge below terminal --}}
                    <p class="mt-4 text-xs text-muted-foreground/50 text-right">
                        Built with care ·
                        <a href="https://gvcjmaad.mychariow.shop/velyx-dev" target="_blank" rel="noopener noreferrer"
                           class="underline decoration-dotted underline-offset-2 transition-colors hover:text-muted-foreground/70">
                            support the project
                        </a>
                    </p>
                </div>

            </div>
        </div>
    </section>

        <x-ui.separator />

    {{-- ─── WHY VELYX ─────────────────────────────────────────────────────── --}}
    <section class="py-24 px-6 lg:px-12 xl:px-24">
        <div class="max-w-7xl mx-auto grid md:grid-cols-3 gap-12 lg:gap-16 xl:gap-20">

            @foreach([
                ['01', 'Copy, not install.', 'Components live in your project directory. Commit them, diff them, modify them. They are source files, not a black box.'],
                ['02', 'Pure PHP and Blade.', 'No JavaScript runtime required. No magic abstractions. Read the code, understand it, debug it in plain sight.'],
                ['03', 'Start and adapt.', "Sensible defaults out of the box. Swap in your own design tokens when you're ready. Every project is different."],
            ] as [$num, $title, $body])
            <div class="space-y-4">
                <span class="font-mono text-xs text-muted-foreground/50 tracking-wider">{{ $num }}</span>
                <h3 class="text-xl font-semibold tracking-tight text-foreground">{{ $title }}</h3>
                <p class="text-muted-foreground leading-relaxed text-[0.9375rem]">{{ $body }}</p>
            </div>
            @endforeach

        </div>
    </section>

    <x-ui.separator />

    {{-- ─── COMPONENT SHOWCASE ─────────────────────────────────────────────── --}}
    <section class="py-24 px-6 lg:px-12 xl:px-24">
        <div class="max-w-7xl mx-auto">

            <div class="flex items-end justify-between mb-10">
                <div class="space-y-1.5">
                    <p class="font-mono text-xs text-muted-foreground/50 tracking-wider uppercase">Library</p>
                    <h2 class="text-3xl font-semibold tracking-tight text-foreground">Everything you need.</h2>
                </div>
                <x-ui.button href="{{ route('docs.page', 'components') }}" wire:navigate variant="outline" iconRight="arrow-right">
                    All {{ count($this->components) }} components
                </x-ui.button>
            </div>

            {{-- Flush grid of live component specimens --}}
            <div class="border border-border rounded-xl overflow-hidden grid sm:grid-cols-2 lg:grid-cols-3 divide-y divide-border sm:divide-x">

                {{-- Buttons --}}
                <div class="p-8 bg-card space-y-4">
                    <span class="font-mono text-xs text-muted-foreground/50">Button</span>
                    <div class="flex flex-wrap gap-2 pt-1">
                        <x-ui.button size="sm">Primary</x-ui.button>
                        <x-ui.button size="sm" variant="outline">Outline</x-ui.button>
                        <x-ui.button size="sm" variant="ghost">Ghost</x-ui.button>
                    </div>
                </div>

                {{-- Badges --}}
                <div class="p-8 bg-card space-y-4">
                    <span class="font-mono text-xs text-muted-foreground/50">Badge</span>
                    <div class="flex flex-wrap gap-2 pt-1">
                        <x-ui.badge>Default</x-ui.badge>
                        <x-ui.badge variant="secondary">Secondary</x-ui.badge>
                        <x-ui.badge variant="success">New</x-ui.badge>
                        <x-ui.badge variant="outline">Outline</x-ui.badge>
                    </div>
                </div>

                {{-- Field + Input --}}
                <div class="p-8 bg-card space-y-4">
                    <span class="font-mono text-xs text-muted-foreground/50">Field</span>
                    <div class="pt-1">
                        <x-ui.field>
                            <x-ui.field.label>Email address</x-ui.field.label>
                            <x-ui.field.content>
                                <x-ui.input placeholder="you@example.com" />
                            </x-ui.field.content>
                        </x-ui.field>
                    </div>
                </div>

                {{-- Checkbox --}}
                <div class="p-8 bg-card space-y-4">
                    <span class="font-mono text-xs text-muted-foreground/50">Checkbox</span>
                    <div class="pt-1 space-y-3">
                        <label class="flex items-center gap-2.5 cursor-pointer text-sm text-foreground">
                            <x-ui.checkbox checked />
                            <span>Email notifications</span>
                        </label>
                        <label class="flex items-center gap-2.5 cursor-pointer text-sm text-muted-foreground">
                            <x-ui.checkbox />
                            <span>Marketing updates</span>
                        </label>
                    </div>
                </div>

                {{-- Progress --}}
                <div class="p-8 bg-card space-y-4">
                    <span class="font-mono text-xs text-muted-foreground/50">Progress</span>
                    <div class="pt-1 space-y-3">
                        <x-ui.progress-bar :percentage="72" label="72%" />
                        <x-ui.progress-bar :percentage="30" label="30%" />
                    </div>
                </div>

                {{-- Avatar --}}
                <div class="p-8 bg-card space-y-4">
                    <span class="font-mono text-xs text-muted-foreground/50">Avatar</span>
                    <div class="pt-1 flex items-center gap-2">
                        <x-ui.avatar size="lg">
                            <x-ui.avatar.image src="https://i.pravatar.cc/80?img=3" alt="Jordan D." />
                        </x-ui.avatar>
                        <x-ui.avatar>
                            <x-ui.avatar.image src="https://i.pravatar.cc/80?img=15" alt="Alex K." />
                        </x-ui.avatar>
                        <x-ui.avatar size="sm">
                            <x-ui.avatar.image src="https://i.pravatar.cc/80?img=44" alt="Maria R." />
                        </x-ui.avatar>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <x-ui.separator />

    {{-- ─── HOW IT WORKS ───────────────────────────────────────────────────── --}}
    <section class="py-24 px-6 lg:px-12 xl:px-24">
        <div class="max-w-7xl mx-auto">

            <div class="mb-12 space-y-1.5">
                <p class="font-mono text-xs text-muted-foreground/50 tracking-wider uppercase">Workflow</p>
                <h2 class="text-3xl font-semibold tracking-tight text-foreground">Three commands. Done.</h2>
            </div>

            <div class="grid md:grid-cols-3 gap-8">

                @foreach([
                    ['01', 'Init your project', 'npx velyx@latest init', 'Detects your Laravel stack, writes a velyx.json config.'],
                    ['02', 'Pick components', 'npx velyx@latest add button', 'Files land in your codebase. Commit and own them.'],
                    ['03', 'Or add many at once', 'npx velyx@latest add button field input', 'Mix and match. Each run is idempotent.'],
                ] as [$step, $title, $command, $description])
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <span class="font-mono text-xs text-muted-foreground/50">{{ $step }}</span>
                        <span class="h-px flex-1 bg-border"></span>
                    </div>
                    <h3 class="font-semibold text-foreground">{{ $title }}</h3>
                    <div class="rounded-lg bg-muted px-4 py-3 font-mono text-sm text-foreground">
                        <span class="text-muted-foreground select-none mr-2">$</span>{{ $command }}
                    </div>
                    <p class="text-sm text-muted-foreground leading-relaxed">{{ $description }}</p>
                </div>
                @endforeach

            </div>
        </div>
    </section>

    <x-ui.separator />

    {{-- ─── FINAL CTA ──────────────────────────────────────────────────────── --}}
    <section class="py-32 px-6 lg:px-12 xl:px-24">
        <div class="max-w-7xl mx-auto max-w-2xl space-y-8">
            <span class="block h-px w-8 bg-foreground/25"></span>
            <h2 class="text-[clamp(2rem,5vw,3.5rem)] font-bold leading-[1.05] tracking-tight text-foreground">
                Your components,<br>
                <span class="font-light text-muted-foreground">your codebase.</span>
            </h2>
            <p class="text-lg text-muted-foreground leading-relaxed">
                Stop fighting black-box component libraries. Copy the code in, make it yours, ship with confidence.
            </p>
            <div class="flex flex-wrap gap-3">
                <x-ui.button href="{{ route('docs.page', 'installation') }}" wire:navigate size="lg" iconRight="arrow-right">
                    Start building
                </x-ui.button>
                <x-ui.button href="{{ route('docs.page', 'components') }}" wire:navigate variant="outline" size="lg">
                    Browse components
                </x-ui.button>
            </div>
        </div>
    </section>

</div>
