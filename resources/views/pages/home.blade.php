<?php

use App\Services\ComponentService;
use Livewire\Component;

new class extends Component
{
    public array $components = [];

    public function mount(ComponentService $componentService): void
    {
        $this->components = $componentService->getAllComponents();
    }
};
?>

<div>
    {{-- Hero --}}
    <section class="relative flex min-h-[55vh] flex-col items-center justify-center overflow-hidden px-4 text-center">
        <div class="pointer-events-none absolute inset-0"
             style="background-image: linear-gradient(to right, var(--border) 1px, transparent 1px), linear-gradient(to bottom, var(--border) 1px, transparent 1px); background-size: 64px 64px; mask-image: radial-gradient(ellipse 80% 70% at 50% 0%, black 0%, transparent 100%); -webkit-mask-image: radial-gradient(ellipse 80% 70% at 50% 0%, black 0%, transparent 100%);"></div>

        <div class="relative z-10 flex flex-col items-center gap-5 py-20">
            <a href="{{ route('docs.page', 'installation') }}" wire:navigate class="inline-flex items-center gap-2 rounded-full border border-border bg-muted/50 px-4 py-1.5 text-xs text-muted-foreground transition-colors hover:bg-muted">
                {{ count($this->components) }} components available
                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>

            <h1 class="max-w-3xl text-4xl font-semibold tracking-tight text-foreground sm:text-5xl lg:text-6xl">
                Build your UI.<br>
                <span class="text-muted-foreground font-normal">Own every pixel.</span>
            </h1>

            <p class="max-w-xl text-[0.9375rem] leading-relaxed text-muted-foreground">
                Production-ready Blade components for Laravel teams. Copy them into your project, adapt to your brand, ship with confidence.
            </p>

            <div class="flex flex-wrap items-center justify-center gap-3">
                <x-ui.button href="{{ route('docs.page', 'installation') }}" wire:navigate iconRight="arrow-right">Get Started</x-ui.button>
                <x-ui.button href="{{ route('docs.page', 'components') }}" wire:navigate variant="outline">Browse Components</x-ui.button>
            </div>
        </div>
    </section>

    {{-- Components Grid --}}
    <section class="border-t border-border bg-background/60 px-4 pb-24 lg:px-6">
        <div class="container-wrapper">
            <div class="columns-1 gap-4 sm:columns-2 lg:columns-3 xl:columns-4 [&>*]:mb-4">

                {{-- Button --}}
                <div class="break-inside-avoid rounded-xl border border-border bg-card p-5">
                    <p class="mb-4 text-xs font-medium text-muted-foreground">Button</p>
                    <div class="flex flex-wrap gap-2">
                        <x-ui.button size="sm">Primary</x-ui.button>
                        <x-ui.button size="sm" variant="outline">Outline</x-ui.button>
                        <x-ui.button size="sm" variant="ghost">Ghost</x-ui.button>
                        <x-ui.button size="sm" variant="destructive">Delete</x-ui.button>
                    </div>
                </div>

                {{-- Badge --}}
                <div class="break-inside-avoid rounded-xl border border-border bg-card p-5">
                    <p class="mb-4 text-xs font-medium text-muted-foreground">Badge</p>
                    <div class="flex flex-wrap gap-2">
                        <x-ui.badge>Default</x-ui.badge>
                        <x-ui.badge variant="secondary">Secondary</x-ui.badge>
                        <x-ui.badge variant="outline">Outline</x-ui.badge>
                        <x-ui.badge variant="destructive">Error</x-ui.badge>
                        <x-ui.badge variant="success">Success</x-ui.badge>
                    </div>
                </div>

                {{-- Card with form feel --}}
                <x-ui.card>
                    <p class="mb-4 text-xs font-medium text-muted-foreground">Input</p>
                    <div class="space-y-3">
                        <div>
                            <x-ui.label>Email address</x-ui.label>
                            <x-ui.input type="email" placeholder="you@example.com" class="mt-1.5" />
                        </div>
                        <div>
                            <x-ui.label>Password</x-ui.label>
                            <x-ui.input type="password" placeholder="••••••••" class="mt-1.5" />
                        </div>
                        <x-ui.button class="w-full" size="sm">Sign In</x-ui.button>
                    </div>
                </x-ui.card>

                {{-- Alert --}}
                <div class="break-inside-avoid rounded-xl border border-border bg-card p-5">
                    <p class="mb-4 text-xs font-medium text-muted-foreground">Alert</p>
                    <div class="space-y-3">
                        <x-ui.alert variant="info" title="Heads up!" description="You can change this in your settings." />
                        <x-ui.alert variant="success" title="Done!" description="Your changes have been saved." />
                        <x-ui.alert variant="destructive" title="Error" description="Something went wrong." />
                    </div>
                </div>

                {{-- Avatar --}}
                <div class="break-inside-avoid rounded-xl border border-border bg-card p-5">
                    <p class="mb-4 text-xs font-medium text-muted-foreground">Avatar</p>
                    <div class="flex items-center gap-4">
                        <x-ui.avatar size="sm" initials="JD" />
                        <x-ui.avatar initials="MK" />
                        <x-ui.avatar size="lg" initials="AB" />
                        <x-ui.avatar size="xl" initials="XL" />
                    </div>
                </div>

                {{-- Progress --}}
                <div class="break-inside-avoid rounded-xl border border-border bg-card p-5">
                    <p class="mb-4 text-xs font-medium text-muted-foreground">Progress Bar</p>
                    <div class="space-y-3">
                        <div>
                            <div class="mb-1.5 flex justify-between text-xs text-muted-foreground">
                                <span>Uploading...</span>
                                <span>64%</span>
                            </div>
                            <x-ui.progress-bar :value="64" />
                        </div>
                        <div>
                            <div class="mb-1.5 flex justify-between text-xs text-muted-foreground">
                                <span>Installing</span>
                                <span>100%</span>
                            </div>
                            <x-ui.progress-bar :value="100" color="success" />
                        </div>
                    </div>
                </div>

                {{-- Skeleton --}}
                <div class="break-inside-avoid rounded-xl border border-border bg-card p-5">
                    <p class="mb-4 text-xs font-medium text-muted-foreground">Skeleton</p>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <x-ui.skeleton class="h-10 w-10 rounded-full" />
                            <div class="flex-1 space-y-2">
                                <x-ui.skeleton class="h-3 w-3/4 rounded" />
                                <x-ui.skeleton class="h-3 w-1/2 rounded" />
                            </div>
                        </div>
                        <x-ui.skeleton class="h-20 w-full rounded-lg" />
                    </div>
                </div>

                {{-- Breadcrumbs --}}
                <div class="break-inside-avoid rounded-xl border border-border bg-card p-5">
                    <p class="mb-4 text-xs font-medium text-muted-foreground">Breadcrumbs</p>
                    <x-ui.breadcrumbs :items="[
                        ['label' => 'Home', 'url' => '#'],
                        ['label' => 'Settings', 'url' => '#'],
                        ['label' => 'Profile'],
                    ]" />
                </div>

                {{-- Card --}}
                <div class="break-inside-avoid rounded-xl border border-border bg-card p-5">
                    <p class="mb-4 text-xs font-medium text-muted-foreground">Card</p>
                    <x-ui.card class="p-4">
                        <div class="flex items-center gap-3">
                            <x-ui.avatar initials="VX" />
                            <div>
                                <p class="text-sm font-medium text-foreground">Velyx Registry</p>
                                <p class="text-xs text-muted-foreground">v1.0.0 released</p>
                            </div>
                        </div>
                        <p class="mt-3 text-xs leading-5 text-muted-foreground">Production-ready components. Copy, adapt, and ship with zero lock-in.</p>
                        <div class="mt-3 flex gap-2">
                            <x-ui.badge variant="secondary">Laravel</x-ui.badge>
                            <x-ui.badge variant="secondary">Livewire</x-ui.badge>
                            <x-ui.badge variant="secondary">Tailwind</x-ui.badge>
                        </div>
                    </x-ui.card>
                </div>

                {{-- KBD --}}
                <div class="break-inside-avoid rounded-xl border border-border bg-card p-5">
                    <p class="mb-4 text-xs font-medium text-muted-foreground">Kbd</p>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between text-xs text-muted-foreground">
                            <span>Save</span>
                            <div class="flex gap-1"><x-ui.kbd>⌘</x-ui.kbd><x-ui.kbd>S</x-ui.kbd></div>
                        </div>
                        <div class="flex items-center justify-between text-xs text-muted-foreground">
                            <span>Search</span>
                            <div class="flex gap-1"><x-ui.kbd>⌘</x-ui.kbd><x-ui.kbd>K</x-ui.kbd></div>
                        </div>
                        <div class="flex items-center justify-between text-xs text-muted-foreground">
                            <span>Copy</span>
                            <div class="flex gap-1"><x-ui.kbd>⌘</x-ui.kbd><x-ui.kbd>C</x-ui.kbd></div>
                        </div>
                    </div>
                </div>

                {{-- Toggle --}}
                <div class="break-inside-avoid rounded-xl border border-border bg-card p-5">
                    <p class="mb-4 text-xs font-medium text-muted-foreground">Toggle</p>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-foreground">Dark mode</span>
                            <x-ui.toggle :checked="true" />
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-foreground">Notifications</span>
                            <x-ui.toggle :checked="false" />
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-foreground">Auto-save</span>
                            <x-ui.toggle :checked="true" />
                        </div>
                    </div>
                </div>

                {{-- Rating --}}
                <div class="break-inside-avoid rounded-xl border border-border bg-card p-5">
                    <p class="mb-4 text-xs font-medium text-muted-foreground">Rating</p>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-muted-foreground">Quality</span>
                            <x-ui.rating :value="5" :max="5" readonly />
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-muted-foreground">Support</span>
                            <x-ui.rating :value="4" :max="5" readonly />
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-muted-foreground">Docs</span>
                            <x-ui.rating :value="3" :max="5" readonly />
                        </div>
                    </div>
                </div>

                {{-- Empty State --}}
                <div class="break-inside-avoid rounded-xl border border-border bg-card p-5">
                    <p class="mb-4 text-xs font-medium text-muted-foreground">Empty State</p>
                    <x-ui.empty-state
                        title="No components yet"
                        description="Add your first component to get started."
                        icon="layout-dashboard"
                    />
                </div>

                {{-- Label --}}
                <div class="break-inside-avoid rounded-xl border border-border bg-card p-5">
                    <p class="mb-4 text-xs font-medium text-muted-foreground">Label</p>
                    <div class="space-y-3">
                        <div>
                            <x-ui.label required>Full Name</x-ui.label>
                            <x-ui.input placeholder="John Doe" class="mt-1.5" />
                        </div>
                        <div>
                            <x-ui.label hint="Optional">Company</x-ui.label>
                            <x-ui.input placeholder="Acme Inc." class="mt-1.5" />
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
