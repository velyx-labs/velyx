@props([
    'props' => [],
])

<div class="preview w-full p-6">
    <div class="grid gap-6 md:grid-cols-2">
        <div class="rounded-lg border border-border p-4">
            <x-ui.empty>
                <x-ui.empty.header>
                    <x-ui.empty.media variant="icon">
                        <x-lucide-folder-open />
                    </x-ui.empty.media>
                    <x-ui.empty.title>No projects yet</x-ui.empty.title>
                    <x-ui.empty.description>
                        Create your first project to start collaborating with your team.
                    </x-ui.empty.description>
                </x-ui.empty.header>
                <x-ui.empty.content>
                    <x-ui.button size="sm">Create project</x-ui.button>
                </x-ui.empty.content>
            </x-ui.empty>
        </div>

        <div class="rounded-lg border border-border p-4">
            <x-ui.empty>
                <x-ui.empty.header>
                    <x-ui.empty.media variant="icon">
                        <x-lucide-bell-off />
                    </x-ui.empty.media>
                    <x-ui.empty.title>No notifications</x-ui.empty.title>
                    <x-ui.empty.description>You are all caught up for now.</x-ui.empty.description>
                </x-ui.empty.header>
            </x-ui.empty>
        </div>
    </div>
</div>
