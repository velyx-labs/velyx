<?php

use App\Services\ComponentService;
use Illuminate\Http\Client\ConnectionException;
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

        $this->stars = Cache::get('github_stars_velyx') ?? $this->fetchStars();
    }

    private function fetchStars(): int
    {
        $repo = config('velyx-docs.github_repo');

        try {
            $response = Http::acceptJson()
                ->timeout(3)
                ->get("https://api.github.com/repos/{$repo}");
        } catch (ConnectionException) {
            $response = null;
        }

        $stars = $response?->successful() ? (int) $response->json('stargazers_count', 0) : 0;

        // A failed lookup is retried after a few minutes instead of an hour.
        Cache::put('github_stars_velyx', $stars, $stars > 0 ? 3600 : 300);

        return $stars;
    }
};
?>

<div class="overflow-x-clip bg-background text-foreground">

    {{-- ─── HERO ──────────────────────────────────────────────────────────── --}}
    <section class="neo-pattern border-b border-border px-4 pt-16 pb-16 sm:px-6 md:pt-28 md:pb-24 lg:px-12 xl:px-24">
        <div class="mx-auto grid max-w-7xl items-center gap-12 lg:grid-cols-[minmax(0,1.15fr)_minmax(0,0.85fr)] lg:gap-16">

            <div class="min-w-0">
                <p class="motion-rise font-mono text-xs uppercase tracking-[0.14em] text-muted-foreground">
                    Blade components for Laravel
                </p>

                <h1 data-reveal-step="1" class="motion-rise mt-5 text-[clamp(2.4rem,8vw,4.6rem)] font-semibold leading-[0.98] tracking-[-0.045em]">
                    Copy the component.<br>
                    <span class="neo-highlight text-muted-foreground/60">It's yours.</span>
                </h1>

                <p data-reveal-step="2" class="motion-rise mt-6 max-w-[46ch] text-base leading-relaxed text-muted-foreground sm:text-lg">
                    Velyx copies components into your codebase — not a dependency.
                    Read them, edit them, commit them. Zero runtime.
                </p>

                <div data-reveal-step="3" class="motion-rise mt-8 flex flex-wrap items-center gap-3">
                    <x-ui.button href="{{ route('docs.page', 'installation') }}" wire:navigate size="lg" iconRight="arrow-right">
                        Get started
                    </x-ui.button>
                    <x-ui.button href="{{ route('docs.page', 'components') }}" wire:navigate variant="outline" size="lg">
                        Browse {{ count($this->components) }} components
                    </x-ui.button>
                </div>

                <div
                    x-data="{ cmd: 'npx velyx@latest add button field', copied: false }"
                    data-reveal-step="3" class="motion-rise neo-shadow mt-6 flex max-w-full flex-wrap items-center gap-x-3 gap-y-2 rounded-lg border border-border bg-muted px-4 py-2.5 font-mono text-sm text-muted-foreground sm:inline-flex"
                >
                    <span class="select-none text-muted-foreground/50">$</span>
                    <span class="min-w-0 break-all text-foreground" x-text="cmd"></span>
                    <button
                        type="button"
                        @click="navigator.clipboard.writeText(cmd); copied = true; setTimeout(() => copied = false, 1500)"
                        class="rounded border border-border px-1.5 py-0.5 text-xs transition-colors hover:text-foreground"
                        :class="copied && 'text-foreground'"
                        x-text="copied ? 'copied' : 'copy'"
                    ></button>
                </div>

                <p class="mt-5 text-sm text-muted-foreground/70">
                    <a
                        href="{{ config('velyx-docs.links.github') }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center gap-1.5 transition-colors hover:text-foreground"
                    >
                        <x-lucide-star class="size-3.5" />
                        @if($stars > 0)
                            <strong class="font-semibold text-foreground">{{ number_format($stars) }}</strong>&nbsp;stars on GitHub
                        @else
                            Star on GitHub
                        @endif
                    </a>
                </p>
            </div>

            {{-- Live component stack --}}
            <div data-reveal-step="4" class="motion-rise mx-auto flex w-full max-w-md min-w-0 flex-col gap-5 lg:mx-0 lg:justify-self-end">
                <div class="motion-lift neo-tilt-r neo-shadow-lg overflow-hidden rounded-xl border border-border bg-card">
                    <div class="neo-fill-blue flex items-center justify-between gap-3 border-b border-border bg-muted px-4 py-2.5">
                        <span class="truncate font-mono text-xs text-muted-foreground">resources/views/components/ui/</span>
                        <span class="flex shrink-0 gap-1.5" aria-hidden="true">
                            <span class="size-2.5 rounded-full border border-border bg-background"></span>
                            <span class="size-2.5 rounded-full border border-border bg-background"></span>
                            <span class="size-2.5 rounded-full border border-border bg-background"></span>
                        </span>
                    </div>
                    <div class="space-y-4 p-5">
                        <x-ui.field>
                            <x-ui.field.label>Email address</x-ui.field.label>
                            <x-ui.field.content>
                                <x-ui.input type="email" placeholder="you@laravel.app" />
                            </x-ui.field.content>
                        </x-ui.field>
                        <div class="flex flex-wrap gap-2.5">
                            <x-ui.button>Subscribe</x-ui.button>
                            <x-ui.button variant="outline">Cancel</x-ui.button>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <div class="motion-lift neo-tilt-l neo-fill-pink neo-shadow flex flex-col gap-3 rounded-xl border border-border bg-card p-4">
                        <span class="font-mono text-[10px] uppercase tracking-[0.14em] text-muted-foreground">badge</span>
                        <div class="flex flex-wrap gap-1.5">
                            <x-ui.badge variant="success">Published</x-ui.badge>
                            <x-ui.badge>Draft</x-ui.badge>
                        </div>
                    </div>
                    <div class="motion-lift neo-tilt-r neo-fill-green neo-shadow flex flex-col gap-3 rounded-xl border border-border bg-card p-4">
                        <span class="font-mono text-[10px] uppercase tracking-[0.14em] text-muted-foreground">progress-bar</span>
                        <x-ui.progress-bar :percentage="72" />
                        <span class="text-xs font-medium">Uploading assets · 72%</span>
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- ─── COMPONENT BAND ────────────────────────────────────────────────── --}}
    <div class="motion-marquee-wrap neo-band overflow-hidden border-b border-border bg-muted py-4 font-mono text-xs uppercase tracking-[0.14em] whitespace-nowrap text-muted-foreground" aria-hidden="true">
        <div class="motion-marquee flex w-max">
            @foreach([1, 2] as $copy)
                <div class="flex shrink-0 gap-4 pr-4">
                    @foreach(['Accordion', 'Button', 'Command palette', 'Date picker', 'Dialog', 'Drawer', 'File upload', 'Sortable list', 'Tabs', 'Toast', 'Tooltip', 'Timeline'] as $name)
                        <span>{{ $name }}</span>
                        <span class="neo-band__sep text-muted-foreground/40">/</span>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>

    {{-- ─── WHAT SHIPS (bento) ────────────────────────────────────────────── --}}
    <section class="border-b border-border px-4 py-16 sm:px-6 md:py-24 lg:px-12 xl:px-24">
        <div class="mx-auto max-w-7xl">
            <div data-reveal class="mb-10 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h2 class="text-[clamp(2rem,4.5vw,3.25rem)] font-semibold leading-none tracking-[-0.03em]">
                        What ships.
                    </h2>
                    <p class="mt-3 max-w-[52ch] text-sm text-muted-foreground sm:text-base">
                        Every cell renders from the same Blade template you'd copy into your project — the landing dogfoods what it ships.
                    </p>
                </div>
                <x-ui.button href="{{ route('docs.page', 'components') }}" wire:navigate variant="secondary" iconRight="arrow-right" class="w-fit shrink-0">
                    All {{ count($this->components) }} components
                </x-ui.button>
            </div>

            <div class="neo-bento grid grid-cols-1 gap-px overflow-hidden rounded-xl border border-border bg-border sm:grid-cols-2 lg:grid-cols-3">

                {{-- Button — wide cell --}}
                <div data-reveal class="motion-lift flex min-w-0 flex-col gap-5 bg-background p-6 sm:col-span-2 sm:p-8">
                    <span class="font-mono text-[10px] uppercase tracking-[0.14em] text-muted-foreground/60">button.blade.php</span>
                    <div class="flex flex-wrap gap-2.5">
                        <x-ui.button size="sm">Primary</x-ui.button>
                        <x-ui.button size="sm" variant="outline">Outline</x-ui.button>
                        <x-ui.button size="sm" variant="ghost">Ghost</x-ui.button>
                        <x-ui.button size="sm" variant="secondary">Secondary</x-ui.button>
                        <x-ui.button size="sm" variant="destructive">Delete</x-ui.button>
                    </div>
                    <div class="flex flex-wrap gap-2.5">
                        <x-ui.button iconRight="arrow-right">Get started</x-ui.button>
                        <x-ui.button variant="outline" icon="icons.gitlab" :lucide="false">GitLab</x-ui.button>
                    </div>
                </div>

                {{-- Badge --}}
                <div data-reveal data-reveal-step="1" class="motion-lift neo-fill-pink flex min-w-0 flex-col gap-4 bg-background p-6 sm:p-8">
                    <span class="font-mono text-[10px] uppercase tracking-[0.14em] text-muted-foreground/60">badge</span>
                    <div class="flex flex-wrap gap-2">
                        <x-ui.badge>Default</x-ui.badge>
                        <x-ui.badge variant="secondary">Secondary</x-ui.badge>
                        <x-ui.badge variant="success">Published</x-ui.badge>
                        <x-ui.badge variant="destructive">Error</x-ui.badge>
                        <x-ui.badge variant="outline">Draft</x-ui.badge>
                    </div>
                </div>

                {{-- Field --}}
                <div data-reveal class="motion-lift flex min-w-0 flex-col gap-5 bg-background p-6 sm:p-8">
                    <span class="font-mono text-[10px] uppercase tracking-[0.14em] text-muted-foreground/60">field</span>
                    <div class="space-y-4">
                        <x-ui.field>
                            <x-ui.field.label>Email address</x-ui.field.label>
                            <x-ui.field.content>
                                <x-ui.input placeholder="you@example.com" />
                            </x-ui.field.content>
                        </x-ui.field>
                        <x-ui.field>
                            <x-ui.field.label>Password</x-ui.field.label>
                            <x-ui.field.content>
                                <x-ui.input type="password" placeholder="••••••••" />
                            </x-ui.field.content>
                        </x-ui.field>
                    </div>
                </div>

                {{-- Checkbox --}}
                <div data-reveal data-reveal-step="1" class="motion-lift neo-fill-yellow flex min-w-0 flex-col gap-5 bg-background p-6 sm:p-8">
                    <span class="font-mono text-[10px] uppercase tracking-[0.14em] text-muted-foreground/60">checkbox</span>
                    <div class="space-y-3 text-sm">
                        <label class="flex min-h-8 cursor-pointer items-center gap-2.5">
                            <x-ui.checkbox checked />
                            <span>Email notifications</span>
                        </label>
                        <label class="flex min-h-8 cursor-pointer items-center gap-2.5">
                            <x-ui.checkbox />
                            <span>Product updates</span>
                        </label>
                        <label class="flex min-h-8 cursor-pointer items-center gap-2.5">
                            <x-ui.checkbox checked />
                            <span>Security alerts</span>
                        </label>
                    </div>
                </div>

                {{-- Progress --}}
                <div data-reveal data-reveal-step="2" class="motion-lift flex min-w-0 flex-col gap-5 bg-background p-6 sm:p-8">
                    <span class="font-mono text-[10px] uppercase tracking-[0.14em] text-muted-foreground/60">progress-bar</span>
                    <div class="space-y-4">
                        @foreach([['Uploading assets', 72], ['Installing deps', 30], ['Build complete', 100]] as [$label, $percentage])
                            <div class="space-y-1.5">
                                <div class="flex justify-between text-xs text-muted-foreground">
                                    <span>{{ $label }}</span><span class="font-mono">{{ $percentage }}%</span>
                                </div>
                                <x-ui.progress-bar :percentage="$percentage" />
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ─── WORKFLOW ──────────────────────────────────────────────────────── --}}
    <section class="neo-fill-blue border-b border-border bg-muted px-4 py-16 sm:px-6 md:py-24 lg:px-12 xl:px-24">
        <div class="mx-auto grid max-w-7xl items-start gap-10 lg:grid-cols-2 lg:gap-14">
            <div class="min-w-0 space-y-6">
                <div data-reveal class="space-y-2">
                    <p class="font-mono text-xs uppercase tracking-[0.14em] text-muted-foreground">Workflow</p>
                    <h2 class="text-[clamp(2rem,4.5vw,3.25rem)] font-semibold leading-none tracking-[-0.03em]">Three commands. Done.</h2>
                </div>

                <ol class="space-y-4">
                    @foreach([
                        ['01', 'Init your project', 'npx velyx@latest init', 'Detects your Laravel stack, writes a velyx.json config.'],
                        ['02', 'Pick components', 'npx velyx@latest add button', 'Files land in your codebase. Commit and own them.'],
                        ['03', 'Or add many at once', 'npx velyx@latest add button field input', 'Every run is idempotent.'],
                    ] as [$step, $title, $command, $description])
                        <li data-reveal data-reveal-step="{{ $loop->iteration }}" class="motion-lift neo-shadow flex gap-4 rounded-xl border border-border bg-background p-4 sm:p-5">
                            <span class="neo-step inline-flex size-10 shrink-0 items-center justify-center rounded-md border border-border font-mono text-xs text-muted-foreground">{{ $step }}</span>
                            <div class="min-w-0 space-y-2">
                                <h3 class="font-semibold">{{ $title }}</h3>
                                <code class="block w-fit max-w-full rounded-md bg-muted px-2.5 py-1 font-mono text-xs break-all text-foreground"><span class="mr-1.5 select-none text-muted-foreground">$</span>{{ $command }}</code>
                                <p class="text-sm leading-relaxed text-muted-foreground">{{ $description }}</p>
                            </div>
                        </li>
                    @endforeach
                </ol>
            </div>

            <div data-reveal data-reveal-step="2" class="neo-shadow-lg min-w-0 overflow-hidden rounded-xl border border-border bg-card lg:mt-16">
                <div class="neo-terminal-bar flex items-center gap-2 border-b border-border bg-muted px-4 py-2.5 font-mono text-xs text-muted-foreground">
                    <span class="flex gap-1.5" aria-hidden="true">
                        <span class="size-2.5 rounded-full border border-border bg-background"></span>
                        <span class="size-2.5 rounded-full border border-border bg-background"></span>
                        <span class="size-2.5 rounded-full border border-border bg-background"></span>
                    </span>
                    <span class="ml-2">~/my-laravel-app</span>
                </div>
                <div class="space-y-1.5 p-5 font-mono text-sm break-words">
                    <div><span class="mr-2 select-none text-muted-foreground/40">$</span>npx velyx@latest add button field</div>
                    <div class="space-y-0.5 pl-5 text-muted-foreground">
                        <div><span class="mr-2 text-foreground">✓</span>button.blade.php</div>
                        <div><span class="mr-2 text-foreground">✓</span>field/index.blade.php</div>
                        <div class="motion-caret pt-1 text-muted-foreground/70">2 components copied — they're yours now.</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ─── FINAL CTA ─────────────────────────────────────────────────────── --}}
    <section class="px-4 py-16 sm:px-6 md:py-24 lg:px-12 xl:px-24">
        <div data-reveal class="neo-cta mx-auto flex max-w-5xl flex-col items-center gap-6 rounded-2xl bg-primary px-6 py-14 text-center text-primary-foreground sm:px-12 md:py-20">
            <h2 class="text-[clamp(2rem,5.5vw,3.75rem)] font-semibold leading-[1.02] tracking-[-0.03em]">
                Your components,<br>
                your codebase.
            </h2>
            <p class="max-w-[48ch] text-base leading-relaxed opacity-75 sm:text-lg">
                Stop fighting black-box component libraries. Paste the code in, make it yours, ship with confidence.
            </p>
            <div class="flex flex-wrap justify-center gap-3">
                <x-ui.button href="{{ route('docs.page', 'installation') }}" wire:navigate variant="outline" size="lg" iconRight="arrow-right" class="text-foreground">
                    Get started
                </x-ui.button>
                <x-ui.button href="{{ route('docs.page', 'components') }}" wire:navigate variant="ghost" size="lg" class="border border-current/30 text-primary-foreground hover:bg-primary-foreground/10 hover:text-primary-foreground">
                    Browse components
                </x-ui.button>
            </div>
        </div>
    </section>

</div>
