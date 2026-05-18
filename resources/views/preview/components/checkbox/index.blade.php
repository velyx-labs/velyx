@props([
    'props' => [],
])

<div class="preview w-full p-8">
    <div class="mx-auto flex max-w-xs flex-col gap-4">
        <label class="flex items-center gap-3 text-sm font-medium">
            <x-ui.checkbox id="preview-checkbox-1" checked />
            Accept terms and conditions
        </label>
        <label class="flex items-center gap-3 text-sm font-medium">
            <x-ui.checkbox id="preview-checkbox-2" />
            Subscribe to newsletter
        </label>
        <label class="flex items-center gap-3 text-sm font-medium text-muted-foreground">
            <x-ui.checkbox id="preview-checkbox-3" disabled />
            Disabled option
        </label>
    </div>
</div>
