@props([
    'props' => [],
])

<div class="preview w-full p-8">
    <div class="mx-auto max-w-sm space-y-4">
        <div>
            <h4 class="text-sm font-medium leading-none">Velyx UI</h4>
            <p class="text-sm text-muted-foreground">An open-source UI component library.</p>
        </div>
        <x-ui.separator />
        <div class="flex h-5 items-center gap-4 text-sm">
            <span>Blog</span>
            <x-ui.separator orientation="vertical" />
            <span>Docs</span>
            <x-ui.separator orientation="vertical" />
            <span>Source</span>
        </div>
    </div>
</div>
