<x-docs.layout :title="$title">
    <x-docs.page-header
        eyebrow="Design"
        title="Colors"
        description="Learn the Velyx color system, semantic tokens, and practical guidance for consistent Laravel interfaces."
    />

    <section class="space-y-10">
        <div class="grid gap-4 md:grid-cols-2">
            @foreach([
                ['Background', '--background', 'Page and app surface color.'],
                ['Foreground', '--foreground', 'Primary text and icon color.'],
                ['Primary', '--primary', 'Main actions and high-emphasis controls.'],
                ['Secondary', '--secondary', 'Lower-emphasis buttons and surfaces.'],
                ['Muted', '--muted', 'Subtle backgrounds and disabled states.'],
                ['Destructive', '--destructive', 'Dangerous actions like delete or remove.'],
            ] as [$label, $token, $description])
                <x-ui.card class="p-5">
                    <div class="flex items-center gap-3">
                        <span class="size-8 rounded-md border bg-primary"></span>
                        <div>
                            <h2 class="font-semibold">{{ $label }}</h2>
                            <p class="font-mono text-sm text-muted-foreground">{{ $token }}</p>
                        </div>
                    </div>
                    <p class="mt-3 text-sm leading-6 text-muted-foreground">{{ $description }}</p>
                </x-ui.card>
            @endforeach
        </div>

        <div>
            <h2 class="text-2xl font-semibold">Token Example</h2>
            <pre class="mt-4 overflow-x-auto rounded-lg border bg-muted p-4"><code class="language-css">:root {
  --background: oklch(1 0 0);
  --foreground: oklch(0.145 0 0);
  --primary: oklch(0.205 0 0);
  --primary-foreground: oklch(0.985 0 0);
}

.dark {
  --background: oklch(0.145 0 0);
  --foreground: oklch(0.985 0 0);
}</code></pre>
        </div>
    </section>
</x-docs.layout>
