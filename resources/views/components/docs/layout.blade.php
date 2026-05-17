@props([
    'title' => 'Velyx Documentation',
    'description' => config('velyx-docs.site_description'),
])

<x-docs.base-layout :title="$title" :description="$description">
    <div class="container-wrapper documentation-grid px-4 py-8 md:px-6 lg:px-8">
        <!-- Mobile Navigation Drawer -->
        <div x-data="{ open: false }" class="lg:hidden mb-6">
            <button
                @click="open = !open"
                class="inline-flex items-center gap-2 rounded-md border border-border bg-background px-3 py-2 text-sm font-medium text-foreground transition-colors hover:bg-muted"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                Navigation
            </button>

            <div
                x-show="open"
                @click.outside="open = false"
                class="fixed inset-0 top-16 z-40 bg-background/95 backdrop-blur supports-backdrop-filter:bg-background/80 lg:hidden"
            >
                <div class="overflow-y-auto p-4 custom-scrollbar">
                    <livewire:docs.sidebar />
                </div>
            </div>
        </div>

        <aside class="hidden lg:block lg:sticky lg:top-8 lg:h-[calc(100vh-4rem)] lg:overflow-y-auto custom-scrollbar">
            <livewire:docs.sidebar />
        </aside>

        <main class="min-w-0 pb-16">
            {{ $slot }}
        </main>
    </div>
</x-docs.base-layout>
