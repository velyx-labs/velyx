@props([
    'title' => 'Velyx Documentation',
    'description' => config('velyx-docs.site_description'),
])

<x-docs.base-layout :title="$title" :description="$description">
    <div class="container-wrapper documentation-grid px-4 py-8 md:px-6 lg:px-8">
        <aside class="lg:sticky lg:top-8 lg:h-[calc(100vh-4rem)] lg:overflow-y-auto custom-scrollbar">
            <livewire:docs.sidebar />
        </aside>

        <main class="min-w-0 pb-16">
            {{ $slot }}
        </main>
    </div>
</x-docs.base-layout>
