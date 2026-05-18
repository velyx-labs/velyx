@props([
    'props' => [],
])

<div class="preview w-full p-6">
    <div class="mx-auto flex w-full max-w-sm flex-col gap-5">

        <div class="flex items-center gap-3">
            <x-ui.skeleton class="size-10 shrink-0 rounded-full" />
            <div class="flex flex-1 flex-col gap-2">
                <x-ui.skeleton class="h-4 w-36" />
                <x-ui.skeleton class="h-3 w-52" />
            </div>
        </div>

        <x-ui.skeleton class="h-32 w-full rounded-lg" />

        <div class="flex flex-col gap-2">
            <x-ui.skeleton class="h-3 w-full" />
            <x-ui.skeleton class="h-3 w-full" />
            <x-ui.skeleton class="h-3 w-4/5" />
        </div>

        <div class="flex gap-2">
            <x-ui.skeleton class="h-8 w-20 rounded-md" />
            <x-ui.skeleton class="h-8 w-24 rounded-md" />
        </div>

    </div>
</div>
