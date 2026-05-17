@props([
    'title' => 'Velyx Documentation',
    'description' => config('velyx-docs.site_description'),
])

<x-docs.base-layout :title="$title" :description="$description">
    <div class="container-wrapper documentation-grid px-4 py-8 md:px-6 lg:px-8">
        <!-- Mobile Navigation Sheet -->
        <div
            x-data="{ sidebarOpen: false }"
            x-effect="document.body.classList.toggle('overflow-hidden', sidebarOpen)"
            class="lg:hidden mb-4"
        >
            <button
                @click="sidebarOpen = true"
                class="inline-flex items-center gap-2 rounded-lg border border-border bg-muted/50 px-3 py-2 text-sm font-medium text-foreground transition-colors hover:bg-muted"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <span>Menu</span>
            </button>

            <!-- Backdrop -->
            <div
                x-show="sidebarOpen"
                @click="sidebarOpen = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-40 bg-black/20 lg:hidden"
            ></div>

            <!-- Drawer -->
            <div
                x-show="sidebarOpen"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="-translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="-translate-x-full"
                class="fixed inset-y-0 left-0 z-50 flex w-64 flex-col border-r border-border bg-background shadow-lg lg:hidden"
            >
                <!-- Drawer Header -->
                <div class="shrink-0 border-b border-border p-4">
                    <div class="flex items-center justify-between">
                        <h2 class="text-sm font-semibold text-foreground">Documentation</h2>
                        <button
                            @click="sidebarOpen = false"
                            class="inline-flex items-center justify-center rounded-md p-1.5 text-muted-foreground transition-colors hover:bg-muted hover:text-foreground"
                        >
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Drawer Content -->
                <div class="min-w-0 flex-1 overflow-y-auto p-4 custom-scrollbar">
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
